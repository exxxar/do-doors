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
                <label for="checkout-name">Название компании\Ф.И.О. ИП</label>
            </div>
            <button v-if="self_clients.length>0" class="btn btn-outline-secondary" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end rounded-0">
                <li><a class="dropdown-item" @click="selectInfo(null)" href="javascript:void(0)"><i
                    class="fa-solid fa-ban"></i> Не выбрано</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" @click="showEditorForm" href="javascript:void(0)"><i
                    class="fa-solid fa-plus"></i> Создать нового</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <template v-for="client in self_clients">
                        <a v-if="client.status != 'individual'" class="dropdown-item" href="javascript:void(0)"
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

        <CartResultForm
            :disabled="timer"
            v-model="clientForm">
            <template #loader>
                <div
                    v-if="timer"
                    class="d-flex justify-content-center my-3">
                    <div class="spinner-border text-primary mx-2" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    Отправляем...
                </div>
            </template>
        </CartResultForm>

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
    props: ["type", "action"],
    directives: {mask},
    computed: {
        ...mapGetters(['getErrors',
            'getDictionary',
            'cartTotalCount', 'cartTotalPrice', 'cartProducts',]),
    },
    watch: {},
    data() {
        return {
            tab: 0,
            timer: null,
            step: 0,
            editor_modal: null,
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
                payed_percent: 70,
                payed_percent_type: 1,
                delivery_terms: null,
                ascent_floor: false,
                work_days: 0,

                installation: {
                    need_door_install: false,
                    count: 0,
                    price: 0,
                    recount_type: 0,
                },
                designer:{
                    is_fix:false,
                    value:0,
                },
                passport: null,
                passport_issued: null,
                need_delivery: false,
                delivery_type: 1,
                delivery_address: null,
                delivery_price: null,
                delivery_city: null,

            }
        }
    },
    mounted() {
        this.loadSelfClients()

        this.cartProducts.forEach(item => {
            if (item.product.need_door_install) {
                this.clientForm.installation.need_door_install = true
                this.clientForm.installation.count += item.quantity
            }

        })

    },
    methods: {

        showEditorForm() {
            window.location.href = "/clients"
        },
        selectItem() {

        },
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
            this.timer = 0
            let tmpTimer = setInterval(() => {
                this.timer++
            }, 1000)

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

            data.append("action", this.action)
            data.append("total_price", this.cartTotalPrice)
            data.append("total_count", this.cartTotalCount)

            this.$store.dispatch("checkoutItems", {
                clientForm: data
            }).then((response) => {

                clearInterval(tmpTimer)
                this.timer = null

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
                clearInterval(tmpTimer)
                this.timer = null

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
