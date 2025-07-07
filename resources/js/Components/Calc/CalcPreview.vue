<script setup>
import DoorItemPreview from "@/Components/Doors/DoorItemPreview.vue";

import DoorItemEditor from "@/Components/Doors/DoorItemEditor.vue";
import CheckoutFormEditor from "@/Components/Cart/CheckoutFormEditor.vue";
</script>
<template>

    <template v-if="doors.length>0">
        <div class="row">
            <div class="col-12 mb-2 d-flex align-items-center">
                <div class="d-flex justify-content-between w-100 align-items-center">
                    <div class="d-flex">
                        <div class="btn-group">
                            <button type="button"
                                    :disabled="doors.length===1"
                                    @click="nextDoor(0)"
                                    class="btn btn-dark rounded-0 "><i class="fa-regular fa-square-caret-left"></i>
                            </button>
                            <button class="btn rounded-0 ">{{ selected_index + 1 }}/{{ doors.length }}</button>
                            <button type="button"
                                    :disabled="doors.length===1"
                                    @click="nextDoor(1)"
                                    class="btn btn-dark rounded-0 ml-2"><i class="fa-regular fa-square-caret-right"></i>
                            </button>


                        </div>
                        <button class="btn btn-dark rounded-0 ml-2" type="button"

                                data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasWithBothOptions"
                                aria-controls="offcanvasWithBothOptions"><i
                            class="fa-solid fa-arrow-up-right-from-square"></i>
                            Список дверей в заказе
                        </button>

                    </div>

                    <div class="d-flex align-items-center">
                        <p>Информация о заказе: <span class="fw-bold">№{{ order.id }} </span></p>
                        <div class="dropdown">
                            <button class="btn btn-link" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bars"></i>
                            </button>
                            <ul class="dropdown-menu">

                                <li><a class="dropdown-item "
                                       @click="sendToTelegram"
                                       href="javascript:void(0)">
                                    <i class="fa-solid fa-paper-plane mr-2"></i>
                                    Отправить в телеграм
                                </a></li>
                                <li><a class="dropdown-item "
                                       @click="sendToBitrix"
                                       href="javascript:void(0)">
                                    <i class="fa-solid fa-square-arrow-up-right mr-2"></i>
                                    Отправить в Битрикс
                                </a></li>
                                <li><a class="dropdown-item "
                                       @click="sendToEmail"
                                       href="javascript:void(0)">
                                    <i class="fa-solid fa-envelope mr-2"></i>
                                    Отправить на почту клиента
                                </a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item"
                                       target="_blank"
                                       :href="'/orders/download-order-excel/'+order.id"><i
                                    class="fa-regular fa-file-excel mr-2"></i>Скачать
                                    Excel-документ по заказу</a></li>


                                <li><a class="dropdown-item"
                                       target="_blank"
                                       :href="'/orders/download-contract?id='+order.id">
                                    <i class="fa-solid fa-file-signature mr-2"></i>Скачать
                                    договор</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <li><a class="dropdown-item text-danger"
                                       @click="removeItem"
                                       href="javascript:void(0)"><i class="fa-solid fa-trash-can mr-2"></i>Удалить</a>
                                </li>
                            </ul>
                        </div>
                    </div>


                </div>


            </div>
        </div>
        <div class="row" v-if="tab===0">

            <div class="col-lg-12">
                <DoorItemPreview
                    :can-edit="canEdit"
                    v-on:edit="onStartEdit"
                    v-if="!loading"
                    v-model="doors[selected_index].door"></DoorItemPreview>
            </div>


        </div>

        <div class="row" v-if="tab===1">

            <div class="col-lg-12">
                <DoorItemEditor
                    :edit-order="true"
                    v-if="!loading"
                    :door="doors[selected_index]"></DoorItemEditor>
            </div>
        </div>

        <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions"
             aria-labelledby="offcanvasWithBothOptionsLabel">
            <div class="offcanvas-header">
                <h5 v-if="cart_tab===0" class="offcanvas-title fw-bold" id="offcanvasWithBothOptionsLabel">Двери в
                    заказе</h5>
                <h5 v-if="cart_tab===1" class="offcanvas-title fw-bold" id="offcanvasWithBothOptionsLabel">Параметры
                    заказа</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body" v-if="cart_tab===0">
                <template v-for="(item, index) in doors">
                    <div
                        @click="selectDoor(index)"
                        v-bind:class="{'border-black':selected_index===index}"
                        class="card btn btn-light text-left p-0 rounded-0  mb-2 cursor-pointer">
                        <div class="card-body ">
                            <h6 class="text-muted font-bold">{{ item.door.purpose || '-' }}:
                                {{ item.door.door_type.title }} {{ item.door.width }}x{{
                                    item.door.height
                                }}x{{ item.door.opening_type?.depth || 0 }}
                            </h6>
                            <h6 class="text-black mb-0">
                                <span
                                    v-if="item.door.box_and_frame_color.title">({{
                                        item.door.box_and_frame_color.title
                                    }})</span>
                                лицо
                                <span class="ml-1"
                                      v-if="item.door.front_side_finish.title">{{
                                        item.door.front_side_finish.title
                                    }} </span>/
                                <span class="ml-1"
                                      v-if="item.door.back_side_finish.title">{{
                                        item.door.back_side_finish.title
                                    }},</span>
                                петли <span v-if="item.door.loops.title">{{ item.door.loops.title }},</span>
                                <span class="ml-1"
                                      v-if="item.door.hinge_manufacturer.title ">{{
                                        item.door.hinge_manufacturer.title
                                    }},</span>
                                <span class="ml-1"
                                      v-if="item.door.fittings_color.title">({{
                                        item.door.fittings_color.title
                                    }}),</span>
                                <span class="ml-1"
                                      v-if="item.door.opening_type.title"> {{ item.door.opening_type.title }},</span>
                                <span class="ml-1"
                                      v-if="item.door.handle_holes.title"> {{ item.door.handle_holes.title }},</span>
                                <span class="ml-1"
                                      v-if="item.door.need_automatic_doorstep"> автоматический порожек,</span>
                                <span class="ml-1" v-if="item.door.need_upper_jumper"> верхняя перемычка,</span>
                                <span class="ml-1" v-if="item.door.need_handle_holes"> дверная ручка,</span>
                                <span class="ml-1" v-if="item.door.handle_holes_type.title"> {{
                                        item.door.handle_holes_type.title
                                    }},</span>
                                <span class="ml-1" v-if="item.door.handle_holes.title"> {{
                                        item.door.handle_holes.title
                                    }},</span>
                                <span class="ml-1" v-if="item.door.need_hidden_door_closer"> скрытый доводчик,</span>
                                <span class="ml-1" v-if="item.door.need_hidden_skirting_board"> скрытый плинтус,</span>
                                <span class="ml-1" v-if="item.door.need_hidden_stopper"> скрытый стопор,</span>
                                <span class="ml-1" v-if="item.door.need_door_install"> установка двери</span>
                            </h6>
                        </div>
                    </div>

                </template>

                <div class="card rounded-0" v-if="!loading">
                    <div class="card-body">
                        <h6 class="fw-bold mb-2">Сводная информация по заказу</h6>
                        <p class="d-flex justify-content-between">Сумма за заказ <span
                            class="fw-bold">{{ order.total_price || 0 }} руб</span></p>
                        <p class="d-flex justify-content-between">Общее число дверей <span
                            class="fw-bold">{{ order.total_count || 0 }} ед.</span></p>
                        <p class="d-flex justify-content-between">Оплачено <span
                            class="fw-bold">{{ order.current_payed || 0 }} руб ({{ order.payed_percent || 0 }}%)</span>
                        </p>
                        <p class="d-flex justify-content-between">
                            Оплата дизайнеру
                            <span class="fw-bold"
                                  v-if="order.config?.designer_work_type"> {{ order.config?.designer_price || 0 }} руб</span>
                            <span class="fw-bold" v-else> {{ order.config?.designer_value || 0 }} %</span>
                        </p>
                        <p class="d-flex justify-content-between">Цена за установку <span
                            class="fw-bold">{{ order.config?.install_price || 0 }} руб</span></p>

                        <p class="d-flex justify-content-between">Цена за доставку <span
                            class="fw-bold">{{ order.config?.delivery_price || 0 }} руб</span></p>

                        <p class="d-flex justify-content-between">Скидка <span
                            class="fw-bold">{{ order.discount?.percent || 0 }}%</span></p>
                        <p class="d-flex justify-content-between">Сумма скидки <span
                            class="fw-bold">{{ order.discount?.amount || 0 }} руб</span></p>

                        <p class="d-flex justify-content-between mt-3 fw-bold">Итого <span>{{ summary }} руб</span></p>
                        <p class="d-flex justify-content-between fw-bold">Итого со скидкой <span>{{ summaryWithDiscount }} руб</span></p>
                    </div>
                </div>
                <div class="card rounded-0" v-else>
                    <div class="card-body d-flex flex-column align-items-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p>Обновляем информацию о заказе...</p>
                    </div>
                </div>
            </div>

            <template v-if="cart_tab===1">
                <div class="offcanvas-body p-3">
                    <CheckoutFormEditor
                        v-on:back="cart_tab=0"
                        :order="order"
                        :doors="doors"></CheckoutFormEditor>
                </div>


                <div class="offcanvas-footer p-3">
                    <button type="button" class="btn btn-outline-secondary w-100 rounded-0 p-3"
                            @click="cart_tab=0">Назад
                    </button>
                </div>
            </template>

            <div
                v-if="cart_tab===0"
                class="offcanvas-footer p-3">
                <button type="button"
                        @click="cart_tab=1"
                        class="btn btn-outline-dark p-3 w-100 rounded-0">Редактировать параметры заказа
                </button>
            </div>

        </div>
    </template>
    <p v-else class="alert alert-dark">
        Данный заказ не содержит информации о дверях
    </p>
</template>
<script>

import {mapGetters} from "vuex";

export default {
    props: ["doors", "order", "canEdit"],
    name: 'MyComponent',
    data() {
        return {
            loading: false,
            tab: 0,
            cart_tab: 0,
            timer: null,
            selected_index: 0,
            formData: {
                contract_number: null,
                work_with_nds: null,
            }
        }
    },
    computed: {
        ...mapGetters(['getErrors']),
        summary() {
            let order = this.order

            return order.total_price + (order.config?.delivery_price || 0) + (order.config?.install_price || 0)
        },
        summaryWithDiscount(){
            return this.summary - (this.order.discount?.amount || 0)
        }
    },
    mounted() {

        this.formData.contract_number = this.order.contract_number || null
    },
    methods: {
       /* loadActualOrderInfo(){
            this.loading = true
            this.$store.dispatch("loadOrder",{
                order_id: this.order.id
            }).then(resp=>{

                this.order = resp.data.data

                this.loading = false
            }).catch(()=>{
                this.loading = false
            })
        },*/
        sendOrder(sendEmail = false, sendTelegram = false, sendToBitrix = false) {
            this.$store.dispatch("sendOrderToBitrix", {
                order_id: this.order.id,
                send_to_telegram: sendTelegram,
                send_to_email: sendEmail,
                send_to_bitrix: sendToBitrix,
            }).then(() => {
                this.$notify({
                    title: "DoDoors",
                    text: "Информация успешно отправлена",
                    type: "success",
                });
            }).catch(() => {
                this.$notify({
                    title: "DoDoors",
                    text: "Ошибка отправки информации ",
                    type: "error",
                });
            })
        },
        sendToBitrix() {
            this.sendOrder(false, false, true)
        },
        sendToTelegram() {
            this.sendOrder(false, true, false)
        },
        sendToEmail() {
            this.sendOrder(true, false, false)
        },
        removeItem() {
            this.$store.dispatch("removeOrder", {
                orderId: this.order.id
            }).then(() => {
                // window.open('/orders','_self')
            }).catch(() => {
                //window.open('/orders','_self')
            })
        },
        nextDoor(direction) {
            if (direction === 1 && this.selected_index > 0) {
                this.selected_index--;
            }

            if (direction === 1 && this.selected_index === 0) {
                this.selected_index = this.doors.length - 1;
            }

            if (direction === 0 && this.selected_index < this.doors.length - 1) {
                this.selected_index++;
            }

            if (direction === 0 && this.selected_index === this.doors.length - 1) {
                this.selected_index = 0;
            }

            this.loading = true
            this.$nextTick(() => {
                this.loading = false
            })
        },
        submit() {
            this.timer = 0
            let tmpTimer = setInterval(() => {
                this.timer++
            }, 1000)

            this.formData.id = this.order.id

            let data = new FormData();
            Object.keys(this.formData)
                .forEach(key => {
                    const item = this.formData[key] || ''
                    if (typeof item === 'object')
                        data.append(key, JSON.stringify(item))
                    else
                        data.append(key, item)
                });

            this.$store.dispatch("contractProcessing", {
                processingForm: data
            }).then((response) => {

                clearInterval(tmpTimer)
                this.timer = null

                this.$notify({
                    title: "DoDoors",
                    text: "Номер договора успешно установлен!",
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

        },
        selectDoor(index) {
            this.loading = true
            this.tab = 0
            this.selected_index = index
            this.$nextTick(() => {
                this.loading = false

            })
        },
        onStartEdit() {
            this.tab = 1
        }
    }
}
</script>
