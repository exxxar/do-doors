<script setup>
import CartResultForm from "@/Components/Cart/CartResultForm.vue";
import CartEditorResultForm from "@/Components/Cart/CartEditorResultForm.vue";
import LawDataForm from "@/Components/Cart/LawDataForm.vue";
import IndividualDataForm from "@/Components/Cart/IndividualDataForm.vue";

</script>

<template>
    <form v-if="(doors||[]).length>0" v-on:submit.prevent="submit">

        <div class="alert alert-danger">
            Внимание! Редактирование заказа на текущий момент на стадии доработки!
        </div>
        <div class="form-floating mb-2">
            <input type="text"
                   v-model="clientForm.contract_number"
                   class="form-control" id="contractNumber" required placeholder="Введите номер договора">
            <label for="contractNumber">Номер договора</label>
        </div>

        <div class="input-group mb-2">
            <div class="form-floating">
                <input type="text" class="form-control" v-model="clientForm.name" id="checkout-name"
                       placeholder="name@example.com" required>
                <label for="checkout-name">Название компании\Ф.И.О. ИП</label>
            </div>

            <button v-if="self_clients.length>0" class="btn btn-outline-secondary" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
            </button>
            <ul
                style="overflow-y: scroll; height: 400px; width: 100%;"
                class="dropdown-menu dropdown-menu-end rounded-0">
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
                    <div class="p-2">
                        <div class="form-floating mb-3">
                            <input type="search"
                                   v-model="search"
                                   class="form-control" id="floatingInput" placeholder="Имя">
                            <label for="floatingInput">Поиск (найдено {{ filteredClients.length || 0 }} клиентов)
                            </label>
                        </div>
                    </div>
                    <template v-for="(client, index) in filteredClients">
                        <a
                            v-bind:class="{'btn-light':index%2===0}"
                            style="word-wrap: break-word; overflow-wrap: break-word;"
                            class="p-2 d-block btn rounded-0" href="javascript:void(0)"
                            @click="selectInfo(client)">{{ client.title || client.phone }}
                            <br><span class="badge rounded-0 btn-dark" style="font-size:8px;">{{
                                    preparedLawStatus(client.status) || 'Не указан'
                                }}</span></a>
                    </template>
                </li>
            </ul>
        </div>


        <a class="btn btn-link mb-2 p-0"
           :href="'/client/'+clientForm.id"
           target="_blank"
           v-if="clientForm.id">Редактировать клиента</a>


        <LawDataForm v-if="(type||0)===0"
                     v-model="clientForm"/>

        <IndividualDataForm v-if="(type||0)===1"
                            v-model="clientForm"/>

        <CartEditorResultForm
            :disabled="timer"
            :doors="doors"
            :order="order"
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
        </CartEditorResultForm>

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
    props: ["type", "action", "doors", "order"],
    directives: {mask},
    computed: {
        ...mapGetters(['getErrors',
            'getDictionary']),
        filteredClients() {
            if (!this.search)
                return this.self_clients || []

            const search = this.search.toLowerCase();

            return this.self_clients.filter(item =>
                (item.title || '').toLowerCase().includes(search) ||
                (item.fio || '').toLowerCase().includes(search)
            );
        }
    },
    watch: {},
    data() {
        return {
            edit_requisites: false,
            search: null,
            tab: 0,
            timer: null,
            step: 0,
            editor_modal: null,
            self_clients: [],

            clientForm: {
                id: null,
                send_to_bitrix: true,
                send_to_mail: false,
                send_to_telegram: true,
                send_to_self_mail: false,
                self_email: null,
                name: null,
                phone: null,
                email: null,
                info: null,
                promo: null,
                contract_number: null,
                dealer_percent: 0,
                summary_price_type: null,
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
                designer: {
                    is_fix: false,
                    value: 0,
                    price: 0,
                },
                passport: null,
                passport_issued: null,
                need_delivery: false,
                delivery_type: 1,
                delivery_address: null,
                delivery_price: null,
                delivery_city: null,

                delivery_service: null,
                discount_data: null,

            }
        }
    },
    mounted() {
        this.loadSelfClients()

        console.log("ordddddder=>", this.order)
        console.log("doooors=>", this.doors)
        this.clientForm.id = this.order.id
        this.clientForm.contract_number = this.order.contract_number || this.order.id
        this.clientForm.name = this.order.contact_person || null
        this.clientForm.phone = this.order.client?.phone || null
        this.clientForm.email = this.order.client?.email || null
        this.clientForm.work_with_nds = this.order.organizational_form === "individual" ? 0 : 1

        this.clientForm.info = this.order.info || null
        this.clientForm.promo = this.order.promo || null
        this.clientForm.dealer_percent = this.order.dealer_percent || 0
        this.clientForm.summary_price_type = this.order.summary_price_type || null

        this.clientForm.items = this.order.items || []
        this.clientForm.current_payed = this.order.current_payed || 0
        this.clientForm.payed_percent = this.order.payed_percent ?? 70
        this.clientForm.payed_percent_type = this.order.payed_percent_type ?? 1

        this.clientForm.delivery_terms = this.order.delivery_terms || null
        this.clientForm.ascent_floor = !!this.order.ascent_floor
        this.clientForm.work_days = this.order.work_days || 0

        this.clientForm.installation = {
            need_door_install: !!this.order.config?.installation?.need_door_install,
            count: this.order.config?.installation?.count || 0,
            price: this.order.config?.installation?.price || 0,
            recount_type: this.order.config?.installation?.recount_type || 0,
        }

        this.clientForm.designer = {
            is_fix: !!this.order.config?.designer?.is_fix,
            value: this.order.config?.designer?.value || 0,
            price: this.order.config?.designer?.price || 0,
        }

        this.clientForm.passport = this.order.client?.passport || null
        this.clientForm.passport_issued = this.order.client?.passport_issued || null

        this.clientForm.delivery_type = this.order.config?.delivery_type ?? 1
        this.clientForm.delivery_address = this.order.config?.delivery_address || null
        this.clientForm.delivery_price = this.order.config?.delivery_price || null
        this.clientForm.delivery_city = this.order.config?.delivery_city || null

        this.clientForm.delivery_service = this.order.delivery_service || null
        this.clientForm.discount_data = {
            discount_value: this.order.discount?.amount|| 0,
            discount_percent: this.order.discount?.percent|| 0,
        }

    },
    methods: {

        showEditorForm() {
            window.location.href = "/clients"
        },
        selectItem() {

        },
        back() {
            this.$emit("callback")
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

            this.clientForm.items = this.doors

            let data = new FormData();
            Object.keys(this.clientForm)
                .forEach(key => {
                    const item = this.clientForm[key] || ''
                    if (typeof item === 'object')
                        data.append(key, JSON.stringify(item))
                    else
                        data.append(key, item)
                });

            data.append("items", JSON.stringify(this.doors))


            this.$store.dispatch("editOrder", {
                clientForm: data
            }).then((response) => {

                clearInterval(tmpTimer)
                this.timer = null

                this.step = 0
                this.tab = 0


                this.$notify({
                    title: "DoDoors",
                    text: "Заказ передан менеджеру!",
                    type: 'success'
                });

                this.loadSelfClients()


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
