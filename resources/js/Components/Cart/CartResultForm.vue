<template>
    <template v-if="clientForm">
        <h6 class="font-bold">Итого цена {{ Math.round(cartTotalPrice * (1 - (discount / 100))) }} ₽ <span
            v-if="discount>0">(скидка {{ discount }}%)</span></h6>

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
                    class="btn btn-outline-secondary text-black rounded-0 mr-2 mb-2">Доставка до адреса
                </button>

                <button
                    type="button"
                    @click="clientForm.delivery_type = 1"
                    v-bind:class="{'btn-dark text-white':clientForm.delivery_type === 1}"
                    class="btn btn-outline-secondary text-black rounded-0 mr-2 mb-2">Самовывоз
                </button>

                <button
                    type="button"
                    @click="clientForm.delivery_type = 2"
                    v-bind:class="{'btn-dark text-white':clientForm.delivery_type === 2}"
                    class="btn btn-outline-secondary text-black rounded-0 mr-2 mb-2">ТК
                </button>


                <button
                    type="button"
                    @click="clientForm.delivery_type = 3"
                    v-bind:class="{'btn-dark text-white':clientForm.delivery_type === 3}"
                    class="btn btn-outline-secondary text-black rounded-0 mr-2 mb-2">Доставка до проходной
                </button>

            </div>

            <!--
                        <div class="form-check form-switch mb-2">
                            <input v-model="clientForm.need_delivery" class="form-check-input" type="checkbox"
                                   role="switch" id="need-delivery">
                            <label class="form-check-label" for="need-delivery">Нужна доставка</label>
                        </div>
            -->

            <template v-if="clientForm.delivery_type === 0">
                <h6 class="mb-2 fw-bold">Информация по доставке</h6>


                <div class="input-group  mb-2">
                    <div class="form-floating ">
                        <input type="number"
                               min="0"
                               class="form-control"
                               v-model="clientForm.delivery_price" id="delivery-price"
                               placeholder="name@example.com" required>
                        <label for="delivery-price">Сумма за доставку</label>
                    </div>
                    <span class="input-group-text rounded-0  border-secondary">
                          <div class="dropdown ">
                        <button class="btn btn-light"
                                type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                           <i class="fa-solid fa-map-location-dot"></i>
                        </button>
                        <ul class="dropdown-menu"
                            style="max-height: 200px; overflow-y: scroll;"
                            aria-labelledby="dropdownMenuButton">
                            <li @click="selectDeliveryVariant(item)" v-for="item in delivery_services"><a
                                class="dropdown-item" href="#">{{ item.title || '-' }}</a></li>

                        </ul>
                    </div>
                    </span>

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
                        class="btn btn-outline-secondary text-black rounded-0 mr-2">Нужен
                    </button>
                    <button
                        type="button"
                        @click="clientForm.ascent_floor = false"
                        v-bind:class="{'btn-dark text-white':clientForm.ascent_floor === false}"
                        class="btn btn-outline-secondary text-black rounded-0 mr-2">Не нужен
                    </button>
                </div>
            </template>

            <h6 class="mb-2 fw-bold">Установка</h6>
            <div class=" my-2">
                <button
                    type="button"
                    @click="clientForm.installation.need_door_install = true"
                    v-bind:class="{'btn-dark text-white':clientForm.installation.need_door_install === true}"
                    class="btn btn-outline-secondary text-black rounded-0 mr-2">Нужна
                </button>
                <button
                    type="button"
                    @click="clientForm.installation.need_door_install = false"
                    v-bind:class="{'btn-dark text-white':clientForm.installation.need_door_install === false}"
                    class="btn btn-outline-secondary text-black rounded-0 mr-2">Не нужна
                </button>
            </div>

            <template v-if="clientForm.installation.need_door_install">
                <div class="form-floating mb-2">
                    <input type="number" class="form-control"
                           v-model="clientForm.installation.count" id="installation-count"
                           placeholder="name@example.com">
                    <label for="installation-count">Дверей к установке</label>
                </div>

                <p style="font-size: 10px;">Производить расчет цены</p>
                <button
                    type="button"
                    @click="clientForm.installation.recount_type = 0"
                    style="font-size: 10px;"
                    v-bind:class="{'btn-dark text-white':clientForm.installation.recount_type===0}"
                    class="btn btn-outline-secondary text-black rounded-0 mr-2">Суммарно
                </button>
                <button
                    type="button"
                    style="font-size: 10px;"
                    @click="clientForm.installation.recount_type = 1"
                    v-bind:class="{'btn-dark text-white':clientForm.installation.recount_type===1}"
                    class="btn btn-outline-secondary text-black rounded-0 mr-2">За единицу
                </button>


                <div class="form-floating my-2">
                    <input type="number" class="form-control"
                           v-model="clientForm.installation.price" id="installation-price"
                           placeholder="name@example.com">
                    <label for="installation-price">Цена за установку, руб
                        <span v-if="clientForm.installation.recount_type===1">(за единицу)</span>
                        <span v-if="clientForm.installation.recount_type===0">(суммарно)</span>
                    </label>
                </div>
            </template>

            <h6 class="mb-2 fw-bold">Работа дизайнера</h6>
            <div class=" my-2 d-flex justify-content-between align-items-center">
                <div>
                    <button
                        type="button"
                        @click="clientForm.designer.is_fix = true"
                        v-bind:class="{'btn-dark text-white':clientForm.designer.is_fix  === true}"
                        class="btn btn-outline-secondary text-black rounded-0 mr-2">Фикс
                    </button>
                    <button
                        type="button"
                        @click="clientForm.designer.is_fix = false"
                        v-bind:class="{'btn-dark text-white':clientForm.designer.is_fix === false}"
                        class="btn btn-outline-secondary text-black rounded-0 mr-2">Процент
                    </button>
                </div>


                <span v-if="!clientForm.designer.is_fix">{{ (designerPrice) }} руб</span>
                <span v-if="clientForm.designer.is_fix">{{ (clientForm.designer.value) }} руб</span>


            </div>

            <div class="form-floating mb-2">
                <input type="number" class="form-control"
                       v-model="clientForm.designer.value" id="designer-value"
                       placeholder="name@example.com">
                <label for="installation-count">
                    <span v-if="clientForm.designer.is_fix">Фиксированная оплата, руб</span>
                    <span v-if="!clientForm.designer.is_fix">Процент за работу,%</span>
                </label>
            </div>


            <slot name="loader"></slot>
            <button
                :disabled="disabled"
                class="btn btn-dark w-100 my-2 rounded-0 p-3">
                Отправить
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
            delivery_services: [],
        }
    },
    mounted() {
        this.clientForm = this.modelValue

        this.selectPayedPercentType(1)

        this.loadServicesByType()
    },
    computed: {
        ...mapGetters(['getErrors',
            'getDictionary',
            'cartTotalCount', 'cartTotalPrice', 'cartProducts',]),
        designerPrice() {
            let price = 0

            this.cartProducts.forEach(item => {
                price += item.product.base_price || 0
            })

            this.clientForm.designer.price = (price * this.clientForm.designer.value / 100).toFixed(2)
            return this.clientForm.designer.price
        }
    },
    watch: {


        'clientForm': {
            handler(val) {

                if (!this.clientForm.designer.is_fix && this.clientForm.designer.value > 100) {
                    this.clientForm.designer.value = 30


                }
                this.$emit("update:modelValue", this.clientForm)
            },
            deep: true
        },

    },
    methods: {
        loadServicesByType() {
            this.$store.dispatch("loadServicesByType", {
                type: 'service_delivery'
            }).then(resp => {
                this.delivery_services = resp.data || []

            }).catch(() => {

            })
        },
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
        selectDeliveryVariant(item) {
            this.clientForm.info = item.title
            this.clientForm.delivery_price = item.price?.retail || 0
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
