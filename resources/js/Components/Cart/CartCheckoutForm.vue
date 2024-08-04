<script setup>
import CartResultForm from "@/Components/Cart/CartResultForm.vue";
import LawDataForm from "@/Components/Cart/LawDataForm.vue";
import IndividualDataForm from "@/Components/Cart/IndividualDataForm.vue";
</script>

<template>
    <form v-if="cartTotalCount>0" v-on:submit.prevent="submit">
        <div class="input-group mb-3">
            <div class="form-floating">
                <input type="text" class="form-control" v-model="clientForm.name" id="checkout-name"
                       placeholder="name@example.com" required>
                <label for="checkout-name">Ваше Ф.И.О.</label>
            </div>
            <button v-if="self_clients.length>0" class="btn btn-outline-secondary" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end rounded-0">
                <li><a class="dropdown-item" @click="selectInfo(null)" href="javascript:void(0)">Не выбрано</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <!-- v-if="clientStatus(client)" -->
                    <template  v-for="client in self_clients_c">
                      
                            <a  class="dropdown-item" href="javascript:void(0)" 
                           @click="selectInfo(client)">{{ client.title || null }}
                            ({{ preparedLawStatus(client.status) || 'Не указан' }})</a>
                       

                    </template>
                </li>
            </ul>
        </div>

        <LawDataForm v-if="(type||0)===0"
                     v-model="clientForm"/>

        <IndividualDataForm v-if="(type||0)===1"
                            v-model="clientForm"/>

        <CartResultForm v-model="clientForm"/>

        <button type="button" class="btn btn-outline-secondary w-100 rounded-0" @click="back">Назад
        </button>
    </form>
    <div class="card rounded-0" v-else>
        <div class="card-body">
            <p>Вы должны добавить в корзину хотя бы одно изделие</p>
        </div>
    </div>
</template>
<script>
import {mapGetters} from "vuex";
import {mask} from 'vue-the-mask'

export default {
    props: ["type"],
    directives: {mask},
    computed: {
        ...mapGetters(['getErrors',
            'getDictionary',
            'cartTotalCount', 'cartTotalPrice', 'cartProducts',]),
       self_clients_c(){
        return (this.type||0)===0 ? this.self_clients.filter(c => c.status== "sole_proprietor" || c.status== "legal_entity" || c.status== "new_client") :
          this.self_clients.filter(c=> c.status == "individual" || c.status== "new_client") 
       },
        
    },
    watch: {},
    data() {
        return {
            tab: 0,
            step: 0,
            self_clients: [],
            clientForm: {
                id: null,
                name: null,
                phone: null,
                email: null,
                info: null,
                promo: null,
                work_with_nds: 1,
                items: [],
                current_payed: 0,
                payed_percent: 0,
                delivery_terms: null,
                work_days: 0,

                passport: null,
                passport_issued: null,
                delivery_address: null,

            }
        }
    },
    mounted() {
        this.loadSelfClients()
    },
    methods: {

        back() {
            this.$emit("back")
        },

        preparedLawStatus(item) {
            const statuses = this.getDictionary.statuses || []
            let status = statuses.find(s => s.value === item) || null
            return status ? status.title : null
        },
        selectInfo(client) {
            if (client == null) {
                this.clientForm.id = null
                this.clientForm.name = null
                this.clientForm.email = null
                this.clientForm.phone = null
                this.clientForm.pasport = null
                this.clientForm.pasport_issued = null
                this.clientForm.fact_address = null
                return;
            }
            this.clientForm.id = client.id || null
            this.clientForm.name = client.title || null
            this.clientForm.email = client.email || null
            this.clientForm.phone = client.phone || null

            this.clientForm.delivery_address = client.fact_address || null
            this.clientForm.pasport = client.pasport || null
            this.clientForm.pasport_issued = client.pasport_issued || null
        },
        clearCart() {
            this.$store.dispatch("clearCart").then((response) => {
                this.$notify({
                    title: "DoDoors",
                    text: "Успешно очищено",
                    type: 'success'
                });

            }).catch(error => {
                this.$notify({
                    title: "DoDoors",
                    text: "Ошибочка...",
                    type: 'error'
                });
            })
        },
        findPromo() {

            this.discount = 0
            if ((this.clientForm.promo || '').length <= 5)
                return;

            this.$store.dispatch("findPromoCode", {
                code: this.clientForm.promo
            }).then((response) => {
                this.discount = response.discount || 0
            })
        },

        loadSelfClients() {

            this.$store.dispatch("loadSelfClients").then(resp => {
                this.self_clients = resp.data || []

            }).catch(() => {

            })
        },
      
        submit() {

            this.clientForm.items = this.cartProducts

            let data = new FormData();
            Object.keys(this.clientForm)
                .forEach(key => {
                    const item = this.clientForm[key] || ''
                    if (typeof item === 'object')
                        data.append(key, JSON.stringify(item))
                    else
                        data.append(key, item)
                });

            data.append("total_price", this.cartTotalPrice)
            data.append("total_count", this.cartTotalCount)

            this.$store.dispatch("checkoutItems", {
                clientForm: data
            }).then((response) => {

                this.step = 0

                this.$store.dispatch("clearCart");

                this.clientForm = {
                    name: null,
                    phone: null,
                    email: null,
                    info: null,
                    passport: null,
                    passport_issued: null,
                    delivery_address: null,

                }

                this.$notify({
                    title: "DoDoors",
                    text: "Заказ передан менеджеру!",
                    type: 'success'
                });

            }).catch(error => {
                this.$notify({
                    title: "DoDoors",
                    text: "Ошибочка...",
                    type: 'error'
                });
            })

        }
    }
}
</script>
