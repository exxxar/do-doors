<template>
    <template v-if="clientForm">


        <h6 class="font-bold d-flex justify-content-between align-items-center mb-2">

            <span>
                Итого цена {{ Math.round(cartTotalPrice * (1 - (discount / 100))) }} ₽ <span
                v-if="discount>0">(скидка {{ discount }}%)</span>
            </span>

            <span @click="blocks.price=!blocks.price">
                    <i v-if="!blocks.price"
                       class="fa-regular fa-square-plus"></i>
                    <i v-else class="fa-regular fa-square-minus"></i>
            </span>
        </h6>


        <template v-if="blocks.price">
            <div class="form-check form-switch my-2">
                <label class="form-check-label"

                       for="need_promo_switcher">

                    <span v-bind:class="{'fw-bold':!need_promo}">скидка</span> \
                    <span v-bind:class="{'fw-bold':need_promo}">промокод</span>
                </label>
                <input
                    v-model="need_promo"
                    class="form-check-input" type="checkbox" role="switch" id="need_promo_switcher">

            </div>


            <template v-if="!need_promo">
                <div class="form-floating mb-2">
                    <input type="text"

                           class="form-control" v-model="discount" id="checkout-promo"
                           placeholder="name@example.com">
                    <label for="checkout-promo">Скидка, %</label>
                </div>
            </template>

            <template v-if="need_promo">
                <div class="form-floating mb-2">
                    <input type="text"
                           class="form-control" @keyup="findPromo" v-model="clientForm.promo" id="checkout-promo"
                           placeholder="name@example.com">
                    <label for="checkout-promo">Промокод</label>
                </div>
            </template>
        </template>

        <div v-if="hasRoles(['manager','administrator'])">

            <template v-if="blocks.price">
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
                        class="btn btn-outline-secondary text-black rounded-0 mr-2"
                        style="font-size: 10px;">70\30</span>
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
            </template>
            <h6 class="mb-2 fw-bold d-flex justify-content-between align-items-center">Срок изготовления
                <span @click="blocks.develop=!blocks.develop">
                    <i v-if="!blocks.develop"
                       class="fa-regular fa-square-plus"></i>
                    <i v-else class="fa-regular fa-square-minus"></i>
                </span>
            </h6>

            <template v-if="blocks.develop">
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
            </template>

            <h6 class="mb-2 fw-bold d-flex justify-content-between align-items-center">Доставка
                <span @click="blocks.delivery=!blocks.delivery">
                    <i v-if="!blocks.delivery"
                       class="fa-regular fa-square-plus"></i>
                    <i v-else class="fa-regular fa-square-minus"></i>
                </span>
            </h6>

            <template v-if="blocks.delivery">
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
                <template v-if="clientForm.delivery_type === 0">
                    <h6 class="mb-2 fw-bold">Информация по доставке</h6>


                    <div class="form-floating mb-2">
                        <input type="number"
                               min="0"
                               class="form-control"
                               v-model="clientForm.delivery_price" id="delivery-price"
                               placeholder="name@example.com" required>
                        <label for="delivery-price">Сумма за доставку</label>
                    </div>


                    <div class="input-group  mb-2">
                        <div class="form-floating">
                            <input type="text" class="form-control"
                                   v-model="clientForm.delivery_city" id="delivery-city"
                                   placeholder="name@example.com">
                            <label for="delivery-city">Город доставки</label>
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
                               v-model="clientForm.delivery_address" id="delivery-address"
                               placeholder="name@example.com">
                        <label for="delivery-address">Адрес доставки</label>
                    </div>

                    <p class="alert alert-light rounded-0 border-black" v-if="clientForm.delivery_service">
                        <span>   {{ clientForm.delivery_service }}</span>
                        <a href="javascript:void(0)"
                           class="d-block p-0 m-0 text-danger"
                           style="font-size:10px;"
                           @click="clientForm.delivery_service = null"><i class="fa-solid fa-xmark"></i> убрать
                            сервис</a>
                    </p>

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
            </template>
            <h6 class="mb-2 fw-bold d-flex justify-content-between align-items-center">Установка
                <span @click="blocks.install=!blocks.install">
                    <i v-if="!blocks.install"
                       class="fa-regular fa-square-plus"></i>
                    <i v-else class="fa-regular fa-square-minus"></i>
                </span>
            </h6>

            <template v-if="blocks.install">
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
            </template>

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


            <h6 class="mb-2 fw-bold d-flex justify-content-between align-items-center">Работа дизайнера
                <span @click="blocks.designer=!blocks.designer">
                    <i v-if="!blocks.designer"
                       class="fa-regular fa-square-plus"></i>
                    <i v-else class="fa-regular fa-square-minus"></i>
                </span>
            </h6>

            <template v-if="blocks.designer">
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
                        <span v-if="!clientForm.designer.is_fix">Процент за работу, %</span>
                    </label>
                </div>
            </template>

            <slot name="loader"></slot>

            <template
                v-if="clientForm.summary_price_type">
                <div
                    v-if="clientForm.summary_price_type.id===3">
                    <div class="form-floating mb-2">
                        <input type="number"
                               min="0"
                               max="100"
                               v-model="clientForm.dealer_percent"
                               class="form-control text-left" id="dealer-percent" required>
                        <label for="dealer-percent">Процент дилера, %</label>
                    </div>
                </div>

            </template>

            <p class="alert alert-light rounded-0 mb-2" v-if="blocks.price_type_attention">
                <strong class="fw-bold">Внимание!</strong> При смене типа цены будет проведен перерасчет всех цен на
                двери и изменены значения начальной внесенной суммы для покупателя
                <a
                    @click="blocks.price_type_attention = false"
                    style="font-size: 10px;"
                    class="d-block text-danger"
                    href="javascript:void(0)">Скрыть и больше не показывать</a>
            </p>

            <div class="btn-group w-100 mb-2">
                <button type="submit"
                        :disabled="disabled"
                        class="btn btn-dark rounded-0 p-3">Отправить
                </button>
                <button type="button"
                        style="width: 70px;"
                        class="btn btn-outline-dark rounded-0 p-3 dropdown-toggle dropdown-toggle-split"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <span v-if="!clientForm.summary_price_type">Тип цены</span>
                    <span v-else>{{ clientForm.summary_price_type.title || '-' }}</span>
                </button>
                <ul class="dropdown-menu rounded-0">
                    <li v-for="item in getDictionary.price_type_variants"><a
                        @click="selectPriceType(item)"
                        class="dropdown-item" href="javascript:void(0)">{{ item.title || '-' }}</a></li>

                </ul>
            </div>
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
            blocks: {
                install: true,
                designer: true,
                delivery: true,
                develop: true,
                price: true,
                price_type_attention: true,
            },
            need_promo: false,
            flgDays: true, // числом или датой дни
            discount: 0,
            clientForm: null,
            delivery_services: [],

        }
    },
    mounted() {

        if (localStorage.getItem("dodoors_cart_checkout_blocks")) {
            const tmp = JSON.parse(localStorage.getItem("dodoors_cart_checkout_blocks"))
            const keysCountOriginal = Object.keys(this.blocks).length || 0
            const keysCountSaved = Object.keys(tmp).length || 0

            console.log("keysCountOriginal", keysCountOriginal)
            console.log("keysCountSaved", keysCountSaved)

            if (keysCountOriginal === keysCountSaved)
                this.blocks = tmp
            else
                localStorage.setItem("dodoors_cart_checkout_blocks", JSON.stringify(this.blocks))
        }


        this.clientForm = this.modelValue

        console.log("this.clientForm.summary_price_type", this.clientForm.summary_price_type)
        if (!this.clientForm.summary_price_type)
            this.getDictionary.price_type_variants.forEach(item => {
                if (item.key === "retail")
                    this.clientForm.summary_price_type = item
            })

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
        'discount': {
            handler(val) {
                this.modelValue.discount_data = {
                    discount_percent:this.discount,
                    discount_amount: Math.round((this.cartTotalPrice * this.discount) / 100)
                }
                this.changeDiscount()
            },
            deep: true
        },
        'blocks': {
            handler(val) {
                localStorage.setItem("dodoors_cart_checkout_blocks", JSON.stringify(this.blocks))
            },
            deep: true
        },
        'need_promo': {
            handler(val) {
                if (this.need_promo)
                    this.discount = 0
            },
            deep: true
        },
        'clientForm.dealer_percent': {
            handler(val) {
                this.recountPrices()
            },
            deep: true
        },
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
        changeDiscount() {

            const discount = Math.round((this.cartTotalPrice * this.discount) / 100)

            this.clientForm.current_payed = Math.max(0, Math.round((
                (this.cartTotalPrice - discount )* this.clientForm.payed_percent) / 100))
        },
        recountPrices() {

            const dealerPercent = this.clientForm.dealer_percent || 0
            const priceType = this.clientForm.summary_price_type

            let items = this.cartProducts
            const dictionary = this.getDictionary

            let sum = 0;

            let base = null

            let tmp_prices = [];

            let type = priceType.key


            let intRound = (arg) => {
                return Math.round(parseInt(arg) / 10) * 10;
            }


            items.forEach(productItem => {

                const doorForm = productItem.product

                let doorTypeFunc = (tmpBasePrice) => {
                    let tmpDoorTypePrice = typeof doorForm["door_type"].price === "object" ?
                        doorForm["door_type"].price[type] :
                        doorForm["door_type"].price

                    let koef = doorForm["door_type"].id !== 3 ? 1 : 0.8
                    let price = doorForm["door_type"].need_percent_price ?
                        (tmpBasePrice * tmpDoorTypePrice) / 100 : (tmpBasePrice * koef + tmpDoorTypePrice)

                    tmp_prices.push({
                        type: "door_type",
                        price: (price || 0) > 0 ? price : tmpBasePrice
                    })

                    return (price || 0) > 0 ? price : tmpBasePrice
                }


                Object.keys(doorForm).forEach(item => {


                    let find = false
                    if (item) {

                        if (typeof doorForm[item] === "object"
                            && doorForm[item] != null
                            && item !== "door_type"
                        ) {
                            if (item === "opening_type" && doorForm[item].sizes) {
                                find = true
                                let index = doorForm[item].sizes.findIndex(c =>
                                    c.width == doorForm.width &&
                                    c.height == doorForm.height)

                                let price = index === -1 ? 0 : doorForm[item].sizes[index].price[type]
                                sum += parseInt(price || 0)

                                console.log("opening_type", price, item)
                                tmp_prices.push({
                                    type: item,
                                    price: price
                                })
                            }

                            if (item.indexOf("_color") !== -1 && doorForm[item].sizes && !find) {
                                find = true

                                let isExcluded = (doorForm[item] || {excludes: []})
                                    .excludes.indexOf(item
                                        .substring(0, item
                                            .indexOf("_color"))) !== -1

                                let price = 0;
                                if (!doorForm[item].assign_with_size)
                                    price = isExcluded ? 0 : doorForm[item].sizes[0].price[type]
                                else {
                                    let index = doorForm[item].sizes.findIndex(c =>
                                        c.width == doorForm.width &&
                                        c.height == doorForm.height)

                                    price = index === -1 || isExcluded ? 0 : doorForm[item].sizes[index].price[type]
                                }

                                sum += parseInt(price || 0)

                                tmp_prices.push({
                                    type: item,
                                    price: price
                                })
                            }

                            if (item === "hinge_manufacturer" && doorForm[item].title != null && !find) {
                                find = true

                                let price = doorForm[item].price[type]
                                let fullPrice = 0

                                if (doorForm.size)
                                    fullPrice = doorForm.size.loops.count * price

                                sum += parseInt(fullPrice || 0)

                                tmp_prices.push({
                                    type: item,
                                    price: price,
                                    full_price: fullPrice
                                })
                            }

                            if (item === "size" && doorForm[item].loops.price && !find) {
                                find = true
                                let price = doorForm[item].loops.price[type]
                                sum += parseInt(price || 0)


                                tmp_prices.push({
                                    type: item,
                                    price: price
                                })
                            }


                            if (item === "service_painting" && doorForm[item].title != null && !find) {
                                find = true

                                let price = doorForm["fittings_color"].is_ral ? doorForm[item].price[type] : 0
                                let fullPrice = 0

                                if (doorForm.size)
                                    fullPrice = (doorForm.size.loops.count + 1) * price

                                sum += fullPrice || 0

                                tmp_prices.push({
                                    type: item,
                                    price: price,
                                    full_price: fullPrice
                                })
                            }


                            if (doorForm[item].price && !find) {

                                let price = (typeof doorForm[item].price === "object") ?
                                    (doorForm[item].price[type] || 0) :
                                    (doorForm[item].price || 0)

                                sum += parseInt(price || 0)

                                tmp_prices.push({
                                    type: item,
                                    price: price
                                })
                            }

                        }
                    }

                })

                let basePrices = dictionary.prices

                let price = 0

                let find = false
                let section = null;
                basePrices.forEach(item => {

                    if (item.width === doorForm.width && item.height === doorForm.height) {
                        find = true
                        section = item;
                    }


                })

                if (find) {
                    base = section.materials.find(m => m.is_base) || {
                        price: {
                            wholesale: 0,
                            dealer: 0,
                            retail: 0,
                            cost: 0,
                        }
                    }

                    let tmpBasePrice = typeof base.price === "object" ? base.price[type] : base.price

                    tmp_prices.push({
                        type: 'base',
                        price: tmpBasePrice
                    })

                    price = parseInt(doorTypeFunc(tmpBasePrice))

                    //sum += parseInt(doorTypeFunc(tmpBasePrice))

                    section.materials.forEach(sub => {
                        if (sub.id === doorForm.front_side_finish.id
                            && !doorForm.front_side_finish.is_base
                        ) {
                            let tmpPrice = typeof sub.price === "object" ? sub.price[type] : sub.price
                            price += tmpPrice

                            this.ces.push({
                                type: 'front_side_finish',
                                price: tmpPrice
                            })
                        }

                        if (sub.id === doorForm.back_side_finish.id
                            && !doorForm.back_side_finish.is_base
                        ) {
                            let tmpPrice = typeof sub.price === "object" ? sub.price[type] : sub.price
                            price += tmpPrice

                            tmp_prices.push({
                                type: 'back_side_finish',
                                price: tmpPrice
                            })
                        }

                    })


                } else {
                    for (let i = 0; i < basePrices.length; i++) {
                        if (basePrices[i].width >= doorForm.width && basePrices[i].height >= doorForm.height) {

                            base = basePrices[i].materials.find(m => m.is_base) || {
                                price: {
                                    wholesale: 0,
                                    dealer: 0,
                                    retail: 0,
                                    cost: 0,
                                }
                            }

                            let tmpBasePrice = typeof base.price === "object" ? base.price[type] : base.price

                            tmp_prices.push({
                                type: 'base',
                                price: tmpBasePrice
                            })


                            price = parseInt(doorTypeFunc(tmpBasePrice))


                            //  sum += parseInt(doorTypeFunc(tmpBasePrice))

                            basePrices[i].materials.forEach(sub => {
                                if (sub.id === doorForm.front_side_finish.id
                                    && !doorForm.front_side_finish.is_base
                                ) {


                                    let tmpPrice = typeof sub.price === "object" ? sub.price[type] : sub.price
                                    price += tmpPrice
                                    tmp_prices.push({
                                        type: 'front_side_finish',
                                        price: tmpPrice
                                    })
                                }

                            })

                            basePrices[i].materials.forEach(sub => {
                                if (sub.id === doorForm.back_side_finish.id
                                    && !doorForm.back_side_finish.is_base
                                ) {

                                    let tmpPrice = typeof sub.price === "object" ? sub.price[type] : sub.price
                                    price += tmpPrice
                                    tmp_prices.push({
                                        type: 'back_side_finish',
                                        price: tmpPrice
                                    })
                                }

                            })
                            break;
                        }
                    }
                }

                doorForm.price = dealerPercent === 0 ? intRound(sum + price) :
                    Math.round((intRound(sum + price) || 0) * (1 + ((dealerPercent || 0) / 100)))

                doorForm.base_price = tmp_prices.find(item => item.type === 'door_type')?.price || 0

            })

            this.$store.dispatch("updateCartItems", items)

            this.changePayedPercent()

        },
        selectPriceType(item) {

            this.clientForm.summary_price_type = item
            this.recountPrices()
            this.changePayedPercent()
        },
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

            this.changeDiscount()
        },
        selectDeliveryVariant(item) {
            this.clientForm.info = item.title
            this.clientForm.delivery_service = item.title
            this.clientForm.delivery_price = item.price?.retail || 0

            const text = item.title;
            const regex = /г\.\s*([А-Яа-яЁё\- ]+)/;

            const match = text.match(regex);
            if (match)
                this.clientForm.delivery_city = match[1].trim();

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
