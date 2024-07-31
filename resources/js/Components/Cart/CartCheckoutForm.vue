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
                    <template v-for="client in self_clients">
                        <a v-if="client.status != 'individual'" class="dropdown-item" href="javascript:void(0)"
                            @click="selectInfo(client)">{{ client.title || null }}
                            ({{ preparedLawStatus(client.status) || 'Не указан' }})</a>
                    </template>
                </li>
            </ul>
        </div>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" v-mask="'+7(###)###-##-##'" v-model="clientForm.phone"
                id="checkout-phone" placeholder="name@example.com" required>
            <label for="checkout-phone">Ваш номер телефона</label>
        </div>

        <div class="form-floating mb-3">
            <input type="email" class="form-control" v-model="clientForm.email" id="checkout-email"
                placeholder="name@example.com" required>
            <label for="checkout-email">Ваш email</label>
        </div>

        <div class="form-floating">
            <textarea class="form-control border-secondary rounded-0" v-model="clientForm.info"
                placeholder="Оставьте свой комментарий" id="checkout-info"></textarea>
            <label for="checkout-info">Дополнительная информация</label>
        </div>
        <div class="row  my-3">
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="1" v-model="clientForm.work_with_nds"
                        name="flexRadioDefault" id="work-with-nds">
                    <label class="form-check-label" for="work-with-nds">
                        Для ООО
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="0" name="flexRadioDefault"
                        v-model="clientForm.work_with_nds" id="work-without-nds">
                    <label class="form-check-label" for="work-without-nds">
                        Для ИП
                    </label>
                </div>
            </div>
        </div>

        <hr class="hr hr-blurry my-3" />

        <h6 class="font-bold">Итого цена {{ Math.round(cartTotalPrice * (1 - (discount / 100))) }} ₽ <span
                v-if="discount>0">(скидка {{ discount }}%)</span></h6>
        <p class="mb-2"><small>Возможно в рассрочку!</small></p>
        <p class="mb-2" style="line-height: 80%;"><small>От цвета шпона или цвета покраски стекла цена не
                зависит, просто уточните эти детали в беседе с менеджером</small></p>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" @keyup="findPromo" v-model="clientForm.promo" id="checkout-promo"
                placeholder="name@example.com">
            <label for="checkout-promo">Промокод</label>
        </div>

        <div v-if="hasRoles(['manager','administrator'])">


            {{clientForm.client}}
            <div class="form-floating mb-3">
                <input type="text" disabled class="form-control" v-model="clientForm.current_payed" id="checkout-name"
                    placeholder="name@example.com" required>
                <label for="checkout-name">Начальная внесенная покупателем сумма, руб</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" v-model="clientForm.payed_percent" id="checkout-name"
                    placeholder="name@example.com" required>
                <label for="checkout-name">Процент внесенной суммы от полной стоимости</label>
            </div>
            <div class="form-check form-switch">
                <input @click="flgDays = !flgDays" v-model="flgDays" class="form-check-input" type="checkbox"
                    role="switch" id="">
                <label class="form-check-label" for="flexSwitchCheckDefault">Указать кол-во рабочих дней / Выбрать
                    конкретную дату</label>
            </div>

            <div v-if="flgDays" class="form-floating mb-3">
                <input type="text" class="form-control" v-model="clientForm.work_days" id="checkout-name"
                    placeholder="name@example.com" required>
                <label for="checkout-name">Кол-во рабочих дней</label>
            </div>
            <div v-else class="form-floating mb-3">
                <input type="date" class="form-control" v-model="clientForm.delivery_terms" id="checkout-name"
                    placeholder="name@example.com" required>
                <label for="checkout-name">Срок передачи товара покупателю</label>
            </div>

            <button class="btn btn-dark w-100 my-2 rounded-0">Отправить и скачать договор</button>
        </div>


        <button v-else class="btn btn-dark w-100 my-2 rounded-0">Отправить</button>
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
    import { mapGetters } from "vuex";
    import { mask } from 'vue-the-mask'

    export default {
        directives: { mask },
        computed: {
            ...mapGetters(['getErrors',
                'getDictionary',
                'cartTotalCount', 'cartTotalPrice', 'cartProducts',]),

        },
        watch: {

            'clientForm.payed_percent': {
                handler(val) {
                    this.clientForm.current_payed = Math.round((
                        this.cartTotalPrice * this.clientForm.payed_percent) / 100)
                },
                deep: true
            },

        },
        data() {
            return {
                tab: 0,
                step: 0,
                discount: 0,
                flgDays: true, // числом или датой дни 
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
                }
            }
        },
        mounted() {
            this.loadSelfClients()
        },
        methods: {
            hasRoles(role) {
                let tmpRole = false

                if (typeof role == "object")
                    this.$page.props.auth.roles.forEach(item => {
                        tmpRole = tmpRole || role.includes(item)
                    })
                else
                    this.$page.props.auth.roles.includes(role)
                return tmpRole
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
                    return;
                }
                this.clientForm.id = client.id || null
                this.clientForm.name = client.title || null
                this.clientForm.email = client.email || null
                this.clientForm.phone = client.phone || null
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