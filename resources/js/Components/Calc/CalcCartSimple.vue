<script setup>
import DoorMiniItem from "@/Components/Doors/DoorMiniItem.vue";
</script>
<template>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="cart" aria-labelledby="cart">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title font-bold">Вы выбрали</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" v-if="cartProducts.length>0">
            <DoorMiniItem

                :item="item" v-for="item in cartProducts"></DoorMiniItem>
        </div>
        <div class="offcanvas-body" v-else>
            <div class="card">
                <div class="card-body">
                    <p>Вы должны добавить в корзину хотя бы одно изделие</p>
                </div>
            </div>
        </div>
        <div class="offcanvas-footer p-3" v-if="cartProducts.length>0">
            <div class="card">
                <div class="card-body">
                    <h6 class="font-bold">Итого цена {{ cartTotalPrice }} ₽</h6>
                    <p class="mb-2"><small>Возможно в рассрочку!</small></p>
                    <p class="mb-2" style="line-height: 80%;"><small>От цвета шпона или цвета покраски стекла цена не
                        зависит, просто уточните эти детали в бесседе с менеджером</small></p>

                    <div v-if="step===0">
                        <button class="btn btn-outline-primary rounded-5 w-100 mb-2" @click="step=1">Обсудить заказ с
                            менеджером
                        </button>
                        <button class="btn btn-outline-primary rounded-5 w-100 mb-2" @click="step=1">Получить цену на
                            почту
                        </button>
                        <button class="btn btn-outline-primary rounded-5 w-100 mb-2" @click="step=1">Получить цену в
                            Telegram
                        </button>
                    </div>

                    <form v-if="step===1" v-on:submit.prevent="submit">
                        <div class="form-floating mb-3">
                            <input type="text"
                                   class="form-control"
                                   v-model="clientForm.name"
                                   id="checkout-name" placeholder="name@example.com" required>
                            <label for="checkout-name">Ваше Ф.И.О.</label>
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
                            <textarea class="form-control"
                                      v-model="clientForm.info"
                                      placeholder="Оставьте свой комментарий" id="checkout-info"></textarea>
                            <label for="checkout-info">Дополнительная информация</label>
                        </div>

                        <button class="btn btn-primary w-100 my-2">Отправить</button>
                        <button class="btn btn-outline-secondary w-100" @click="step=0">Назад</button>
                    </form>

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
        ...mapGetters(['getErrors', 'cartTotalCount', 'cartTotalPrice', 'cartProducts']),

    },
    data() {
        return {
            step: 0,
            clientForm: {
                name: null,
                phone: null,
                email: null,
                info: null,
                items:[]
            }
        }
    },
    methods: {
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
