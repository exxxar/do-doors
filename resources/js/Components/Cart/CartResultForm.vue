<template>
    <template v-if="clientForm">
        <h6 class="font-bold">Итого цена {{ Math.round(cartTotalPrice * (1 - (discount / 100))) }} ₽ <span
            v-if="discount>0">(скидка {{ discount }}%)</span></h6>
        <p class="mb-2"><small>Возможно в рассрочку!</small></p>
        <p class="mb-2" style="line-height: 80%;"><small>От цвета шпона или цвета покраски стекла цена не
            зависит, просто уточните эти детали в беседе с менеджером</small></p>
        <div class="form-floating mb-3">
            <input type="text"
                   class="form-control" @keyup="findPromo" v-model="clientForm.promo" id="checkout-promo"
                   placeholder="name@example.com">
            <label for="checkout-promo">Промокод</label>
        </div>

        <div v-if="hasRoles(['manager','administrator'])">

            <div class="form-floating mb-3">
                <input type="text" class="form-control"
                       @change="changeCurrentPayed"
                       v-model="clientForm.current_payed" id="checkout-name"
                       placeholder="" required>
                <label for="checkout-name">Начальная внесенная покупателем сумма, руб</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control"
                       @change="changePayedPercent"
                       v-model="clientForm.payed_percent" id="checkout-name"
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

            <button
                class="btn btn-dark w-100 my-2 rounded-0">Отправить и скачать договор
            </button>
        </div>

        <button v-else class="btn btn-dark w-100 my-2 rounded-0">Отправить</button>
    </template>
</template>
<script>
import {mapGetters} from "vuex";

export default {
    props: ['modelValue'],
    data() {
        return {
            flgDays: true, // числом или датой дни
            discount: 0,
            clientForm: null,
        }
    },
    mounted() {
        this.clientForm = this.modelValue
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
