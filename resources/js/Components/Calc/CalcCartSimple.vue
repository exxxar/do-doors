<script setup>
import CartCheckoutForm from "@/Components/Cart/CartCheckoutForm.vue";
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
            <div class="card rounded-0" v-else>
                <div class="card-body">
                    <p>Вы должны добавить в корзину хотя бы одно изделие</p>
                </div>
            </div>
        </div>
        <div class="offcanvas-body" v-if="tab===1">
            <CartCheckoutForm
                v-on:back="back"
                v-if="step===1"></CartCheckoutForm>
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

        }
    },
    mounted() {

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
