<script setup>
import DoorItemPreview from "@/Components/Doors/DoorItemPreview.vue";

import DoorItemEditor from "@/Components/Doors/DoorItemEditor.vue";
import CheckoutFormEditor from "@/Components/Cart/CheckoutFormEditor.vue";
</script>
<template>

    <template v-if="doors.length>0">
        <div class="row">
            <div class="col-12 mb-2 d-flex align-items-center">
                <p>Информация о заказе: <span class="fw-bold">№{{ order.id }} </span></p>
                <button class="btn btn-dark rounded-0 ml-2" type="button"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasWithBothOptions"
                        aria-controls="offcanvasWithBothOptions"><i class="fa-solid fa-arrow-up-right-from-square"></i>
                    Список дверей в заказе
                </button>
                <a :href="'/link/'+order.id"
                   target="_blank"
                   class="btn btn-dark rounded-0 ml-2"><i class="fa-solid fa-up-right-from-square"></i></a>
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
                <h5 v-if="cart_tab===0" class="offcanvas-title fw-bold" id="offcanvasWithBothOptionsLabel">Двери в заказе</h5>
                <h5 v-if="cart_tab===1" class="offcanvas-title fw-bold" id="offcanvasWithBothOptionsLabel">Параметры заказа</h5>
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
                                {{ item.door.door_type.title }} {{ item.door.width }}x{{ item.door.height }}x
                                {{ item.door.opening_type?.depth || 0 }}
                            </h6>
                            <h6 class="text-black mb-0">
                                <span
                                    v-if="item.door.box_and_frame_color.title">({{ item.door.box_and_frame_color.title }})</span>
                                лицо
                                <span class="ml-1"
                                      v-if="item.door.front_side_finish.title">{{ item.door.front_side_finish.title }} </span>/
                                <span class="ml-1"
                                      v-if="item.door.back_side_finish.title">{{ item.door.back_side_finish.title }},</span>
                                петли <span v-if="item.door.loops.title">{{ item.door.loops.title }},</span>
                                <span class="ml-1"
                                      v-if="item.door.hinge_manufacturer.title ">{{ item.door.hinge_manufacturer.title }},</span>
                                <span class="ml-1"
                                      v-if="item.door.fittings_color.title">({{ item.door.fittings_color.title }}),</span>
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

            </div>

            <template v-if="cart_tab===1">
                <div class="offcanvas-body p-3">
                    <CheckoutFormEditor
                        v-on:back="cart_tab=0"
                        :order="order"
                        :doors="doors"></CheckoutFormEditor>
                </div>

            </template>

            <div
                v-if="cart_tab===0"
                class="offcanvas-footer p-3">
                <button type="button"
                        @click="cart_tab=1"
                        class="btn btn-outline-dark p-3 w-100 rounded-0">Редактировать параметры заказа</button>
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
            cart_tab:0,
            timer:null,
            selected_index: 0,
            formData:{
                contract_number:null,
                work_with_nds:null,
            }
        }
    },
    computed: {
        ...mapGetters(['getErrors']),
    },
    mounted() {
        console.log("preview doors", this.doors)
        console.log("preview order", this.order)

        this.formData.contract_number = this.order.contract_number || null
    },
    methods: {

        submit(){
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
