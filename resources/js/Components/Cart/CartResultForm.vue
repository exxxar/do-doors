<template>
    <template v-if="clientForm">
        <h6 class="font-bold">Итого цена {{ Math.round(cartTotalPrice * (1 - (discount / 100))) }} ₽ <span
            v-if="discount>0">(скидка {{ discount }}%)</span></h6>
        <p class="mb-2"><small>Возможно в рассрочку!</small></p>
        <p class="mb-2" style="line-height: 80%;"><small>От цвета шпона или цвета покраски стекла цена не
            зависит, просто уточните эти детали в беседе с менеджером</small></p>
        <div class="form-floating mb-2">
            <input type="text"
                   class="form-control" @keyup="findPromo" v-model="clientForm.promo" id="checkout-promo"
                   placeholder="name@example.com">
            <label for="checkout-promo">Промокод</label>
        </div>

        <div v-if="hasRoles(['manager','administrator'])">

            <p><small>Начальная внесенная покупателем сумма</small></p>
            <div class="form-floating mb-2">
                <input type="text" class="form-control"
                       @change="changeCurrentPayed"
                       v-model="clientForm.current_payed" id="checkout-name"
                       placeholder="" required>
                <label for="checkout-name">Начальная сумма, руб</label>
            </div>

            <p><small>Процент внесенной суммы от полной стоимости</small></p>
            <p class="my-2">
                <span
                    @click="selectPayedPercentType(0)"
                    v-bind:class="{'btn-dark text-white':clientForm.payed_percent_type === 0}"
                    class="btn btn-outline-secondary text-black rounded-0 mr-2" style="font-size: 10px;">50\50</span>
                <span
                    @click="selectPayedPercentType(1)"
                    v-bind:class="{'btn-dark text-white':clientForm.payed_percent_type === 1}"
                    class="btn btn-outline-secondary text-black rounded-0 mr-2" style="font-size: 10px;">70\30</span>
                <span
                    @click="selectPayedPercentType(2)"
                    v-bind:class="{'btn-dark text-white':clientForm.payed_percent_type === 2}"
                    class="btn btn-outline-secondary text-black rounded-0 mr-2"
                    style="font-size: 10px;">100% предоплата</span>
            </p>
            <div class="form-floating mb-2">
                <input type="text" class="form-control"
                       @change="changePayedPercent"
                       v-model="clientForm.payed_percent" id="checkout-name"
                       placeholder="name@example.com" required>
                <label for="checkout-name">%</label>
            </div>

            <div class="form-check form-switch">
                <input @click="flgDays = !flgDays" v-model="flgDays" class="form-check-input" type="checkbox"
                       role="switch" id="">
                <label class="form-check-label" for="flexSwitchCheckDefault">Указать кол-во рабочих дней / Выбрать
                    конкретную дату</label>
            </div>

            <div v-if="flgDays" class="form-floating mb-2">
                <input type="text" class="form-control" v-model="clientForm.work_days" id="checkout-name"
                       placeholder="name@example.com" required>
                <label for="checkout-name">Кол-во рабочих дней</label>
            </div>

            <div v-else class="form-floating mb-2">
                <input type="date" class="form-control" v-model="clientForm.delivery_terms" id="checkout-name"
                       placeholder="name@example.com" required>
                <label for="checkout-name">Срок передачи товара покупателю</label>
            </div>


            <div class=" my-2">

                <button
                    type="button"
                    @click="clientForm.delivery_type = 0"
                    v-bind:class="{'btn-dark text-white':clientForm.delivery_type === 0}"
                    class="btn btn-outline-secondary text-black rounded-0 mr-2 mb-2" >Доставка до адреса</button>

                <button
                    type="button"
                    @click="clientForm.delivery_type = 1"
                    v-bind:class="{'btn-dark text-white':clientForm.delivery_type === 1}"
                    class="btn btn-outline-secondary text-black rounded-0 mr-2 mb-2" >Самовывоз</button>

                <button
                    type="button"
                    @click="clientForm.delivery_type = 2"
                    v-bind:class="{'btn-dark text-white':clientForm.delivery_type === 2}"
                    class="btn btn-outline-secondary text-black rounded-0 mr-2 mb-2" >ТК</button>


                <button
                    type="button"
                    @click="clientForm.delivery_type = 3"
                    v-bind:class="{'btn-dark text-white':clientForm.delivery_type === 3}"
                    class="btn btn-outline-secondary text-black rounded-0 mr-2 mb-2" >Доставка до проходной</button>

            </div>

<!--
            <div class="form-check form-switch mb-2">
                <input v-model="clientForm.need_delivery" class="form-check-input" type="checkbox"
                       role="switch" id="need-delivery">
                <label class="form-check-label" for="need-delivery">Нужна доставка</label>
            </div>
-->

            <template v-if="clientForm.delivery_type === 0">
                <div class="form-floating mb-2">
                    <input type="number"
                           min="0"
                           class="form-control"
                           v-model="clientForm.delivery_price" id="delivery-price"
                           placeholder="name@example.com" required>
                    <label for="delivery-price">Сумма за доставку</label>
                </div>

                <div class="form-floating mb-2">
                    <input type="text" class="form-control"
                           v-model="clientForm.delivery_city" id="delivery-city"
                           placeholder="name@example.com" required>
                    <label for="delivery-city">Город доставки</label>
                </div>

                <div class="form-floating mb-2">
                    <input type="text" class="form-control"
                           v-model="clientForm.delivery_address" id="delivery-address"
                           placeholder="name@example.com" required>
                    <label for="delivery-address">Адрес доставки</label>
                </div>

                <p class="mb-2">Подъем на этаж</p>
                <div class=" my-2">



                        <button
                            type="button"
                            @click="clientForm.ascent_floor = true"
                            v-bind:class="{'btn-dark text-white':clientForm.ascent_floor === true}"
                            class="btn btn-outline-secondary text-black rounded-0 mr-2" >Нужен</button>



                        <button
                            type="button"
                            @click="clientForm.ascent_floor = false"
                            v-bind:class="{'btn-dark text-white':clientForm.ascent_floor === false}"
                            class="btn btn-outline-secondary text-black rounded-0 mr-2" >Не нужен</button>



                </div>
            </template>

            <slot name="loader"></slot>
            <button
                :disabled="disabled"
                class="btn btn-dark w-100 my-2 rounded-0 p-3">
                Отправить и скачать договор
            </button>
        </div>
        <template v-else>
            <button
                :disabled="disabled"
                class="btn btn-dark w-100 my-2 rounded-0 p-3">Отправить
            </button>
        </template>

    </template>
</template>
<script>
import {mapGetters} from "vuex";

export default {
    props: ['modelValue', 'disabled'],
    data() {
        return {
            flgDays: true, // числом или датой дни
            discount: 0,
            clientForm: null,
        }
    },
    mounted() {
        this.clientForm = this.modelValue

        this.selectPayedPercentType(1)
    },
    computed: {
        ...mapGetters(['getErrors',
            'getDictionary',
            'cartTotalCount', 'cartTotalPrice', 'cartProducts',]),

    },
    watch: {
        'clientForm': {
            handler(val) {
                this.$emit("update:modelValue", this.clientForm)
            },
            deep: true
        },

    },
    methods: {
        selectPayedPercentType(type) {
            this.clientForm.payed_percent_type = type
            switch (type) {
                case 0:
                    this.clientForm.payed_percent = 50;
                    break;
                default:
                case 1:
                    this.clientForm.payed_percent = 70;
                    break;
                case 2:
                    this.clientForm.payed_percent = 100;
                    break;
            }
            this.changePayedPercent()
        },
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
        changeCurrentPayed() {
            this.clientForm.payed_percent = Math.round((this.clientForm.current_payed /
                this.cartTotalPrice) * 100)
        },
        changePayedPercent() {
            this.clientForm.current_payed = Math.round((
                this.cartTotalPrice * this.clientForm.payed_percent) / 100)
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

    }
}
</script>
