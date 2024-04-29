<script setup>
import DoorMiniItem from "@/Components/Doors/DoorMiniItem.vue";
</script>
<template>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="cart" aria-labelledby="cart">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title font-bold">
                <span v-if="tab===0">Вы выбрали</span>
                <span v-if="tab===1">Оформление заказа</span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" v-if="tab===0">
            <template v-if="cartProducts.length>0">
                <DoorMiniItem
                    :item="item" v-for="item in cartProducts"></DoorMiniItem>

                <div class="hr my-3"></div>
                <button
                    @click="downloadCartExcel"
                    class="btn btn-dark rounded-0 w-100 mb-2">
                    Скачать в виде Excel-файла
                </button>
                <button
                    @click="clearCart"
                    class="btn btn-outline-secondary rounded-0 w-100 mb-2">
                    Очистить корзину
                </button>
            </template>
            <div class="card" v-else>
                <div class="card-body">
                    <p>Вы должны добавить в корзину хотя бы одно изделие</p>
                </div>
            </div>
        </div>
        <div class="offcanvas-body" v-if="tab===1">
            <form v-if="step===1" v-on:submit.prevent="submit">


                <div class="input-group mb-3">
                    <div class="form-floating">
                        <input type="text"
                               class="form-control"
                               v-model="clientForm.name"
                               id="checkout-name" placeholder="name@example.com" required>
                        <label for="checkout-name">Ваше Ф.И.О.</label>
                    </div>
                    <button
                        v-if="self_clients.length>0"
                        class="btn btn-outline-secondary" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end rounded-0">
                        <li><a class="dropdown-item"
                               @click="selectInfo(null)"
                               href="javascript:void(0)">Не выбрано</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item"
                               href="javascript:void(0)"
                               @click="selectInfo(client)"
                               v-for="client in self_clients">{{ client.title || null }}
                            ({{ preparedLawStatus(client.status) || 'Не указан' }})</a>
                        </li>
                    </ul>
                </div>

                <div class="form-floating mb-3">
                    <input type="text"
                           class="form-control"
                           v-mask="'+7(###)###-##-##'"
                           v-model="clientForm.phone"
                           id="checkout-phone" placeholder="name@example.com" required>
                    <label for="checkout-phone">Ваш номер телефона</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email"
                           class="form-control"
                           v-model="clientForm.email"
                           id="checkout-email" placeholder="name@example.com" required>
                    <label for="checkout-email">Ваш email</label>
                </div>

                <div class="form-floating">
                            <textarea class="form-control border-secondary rounded-0"
                                      v-model="clientForm.info"
                                      placeholder="Оставьте свой комментарий" id="checkout-info"></textarea>
                    <label for="checkout-info">Дополнительная информация</label>
                </div>
                <div class="row  my-3">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="radio"
                                   value="1"
                                   v-model="clientForm.work_with_nds"
                                   name="flexRadioDefault"
                                   id="work-with-nds">
                            <label class="form-check-label"
                                   for="work-with-nds">
                                Работаю с НДС
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="radio"
                                   value="0"
                                   name="flexRadioDefault"
                                   v-model="clientForm.work_with_nds"
                                   id="work-without-nds">
                            <label class="form-check-label"
                                   for="work-without-nds">
                                Работаю без НДС
                            </label>
                        </div>
                    </div>
                </div>

                <hr class="hr hr-blurry my-3"/>

                <h6 class="font-bold">Итого цена {{ Math.round(cartTotalPrice * (1 - (discount / 100))) }} ₽ <span v-if="discount>0">(скидка {{discount}}%)</span></h6>
                <div class="form-floating mb-3">
                    <input type="text"
                           class="form-control"
                           @keyup="findPromo"
                           v-model="clientForm.promo"
                           id="checkout-promo" placeholder="name@example.com">
                    <label for="checkout-promo">Промокод</label>
                </div>

                <button class="btn btn-dark w-100 my-2 rounded-0">Отправить</button>
                <button class="btn btn-outline-secondary w-100 rounded-0" @click="back">Назад</button>
            </form>
        </div>
        <div class="offcanvas-footer p-3" v-if="cartProducts.length>0&&tab===0">
            <div class="card rounded-0">
                <div class="card-body">
                    <h6 class="font-bold">Итого цена {{ cartTotalPrice }} ₽</h6>
                    <p class="mb-2"><small>Возможно в рассрочку!</small></p>
                    <p class="mb-2" style="line-height: 80%;"><small>От цвета шпона или цвета покраски стекла цена не
                        зависит, просто уточните эти детали в беседе с менеджером</small></p>

                    <div v-if="step===0">
                        <button class="btn btn-dark rounded-0 w-100 mb-2" @click="checkout">Обсудить заказ с
                            менеджером
                        </button>
                        <button class="btn btn-outline-secondary rounded-0 w-100 mb-2" @click="checkout">Получить цену
                            на
                            почту
                        </button>
                        <button class="btn btn-outline-secondary rounded-0 w-100 mb-2" @click="checkout">Получить цену в
                            Telegram
                        </button>
                    </div>


                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import {mask} from 'vue-the-mask'

export default {
    directives: {mask},
    computed: {
        ...mapGetters(['getErrors',
            'getDictionary',
            'cartTotalCount', 'cartTotalPrice', 'cartProducts',]),

    },
    data() {
        return {
            tab: 0,
            step: 0,
            discount: 0,
            self_clients: [],
            clientForm: {
                client_id: null,
                name: null,
                phone: null,
                email: null,
                info: null,
                promo: null,
                work_with_nds: 1,
                items: []
            }
        }
    },
    mounted() {
        this.loadSelfClients()
    },
    methods: {
        back() {
            this.step = 0
            this.tab = 0
        },
        checkout() {
            this.step = 1
            this.tab = 1
        },
        preparedLawStatus(item) {
            const statuses = this.getDictionary.statuses || []
            let status = statuses.find(s => s.value === item) || null
            return status ? status.title : null
        },
        selectInfo(client) {

            console.log(client)

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
            if ((this.clientForm.promo||'').length<=5)
                return;

            this.$store.dispatch("findPromoCode", {
                code: this.clientForm.promo
            }).then((response) => {
                this.discount = response.discount || 0
            })
        },
        downloadCartExcel() {

            let items = this.cartProducts

            let data = new FormData();
            data.append("items", JSON.stringify(items))

            this.$store.dispatch("downloadExcel", {
                cardData: data
            }).then((response) => {


                var fileURL = window.URL.createObjectURL(new Blob([response]));
                var fURL = document.createElement('a');

                fURL.href = fileURL;
                fURL.setAttribute('download', 'cart.xls');
                document.body.appendChild(fURL);

                fURL.click();

                this.$notify({
                    title: "DoDoors",
                    text: "Excel успешно скачан!",
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
<style>
.hr {
    width: 100%;
    height: 1px;
    background-color: #e0e0e0;
}
</style>
