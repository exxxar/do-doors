<template>
    <div class="card mb-2 rounded-0" v-if="door">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="text-muted font-bold">{{ door.purpose || '-' }}:
                        {{ door.door_type.title }} {{ door.width }}x{{ door.height }}x
                        {{ door.opening_type?.depth || 0 }}
                    </h6>
                    <h6 class="text-black mb-0">
                        <span
                            v-if="door.box_and_frame_color.title">({{ door.box_and_frame_color.title }})</span>
                        лицо
                        <span class="ml-1"
                              v-if="door.front_side_finish.title">{{ door.front_side_finish.title }} </span>/
                        <span class="ml-1"
                              v-if="door.back_side_finish.title">{{ door.back_side_finish.title }},</span>
                        петли <span v-if="door.loops.title">{{ door.loops.title }},</span>
                        <span class="ml-1"
                              v-if="door.hinge_manufacturer.title ">{{ door.hinge_manufacturer.title }},</span>
                        <span class="ml-1"
                              v-if="door.fittings_color.title">({{ door.fittings_color.title }}),</span>
                        <span class="ml-1"
                              v-if="door.opening_type.title"> {{ door.opening_type.title }},</span>
                        <span class="ml-1"
                              v-if="door.handle_holes.title"> {{ door.handle_holes.title }},</span>
                        <span class="ml-1" v-if="door.need_automatic_doorstep"> автоматический порожек,</span>
                        <span class="ml-1" v-if="door.need_upper_jumper"> верхняя перемычка,</span>
                        <span class="ml-1" v-if="door.need_handle_holes"> дверная ручка,</span>
                        <span class="ml-1" v-if="door.handle_holes_type.title"> {{
                                door.handle_holes_type.title
                            }},</span>
                        <span class="ml-1" v-if="door.handle_holes.title"> {{
                                door.handle_holes.title
                            }},</span>
                        <span class="ml-1" v-if="door.need_hidden_door_closer"> скрытый доводчик,</span>
                        <span class="ml-1" v-if="door.need_hidden_skirting_board"> скрытый плинтус,</span>
                        <span class="ml-1" v-if="door.need_hidden_stopper"> скрытый стопор,</span>
                        <span class="ml-1" v-if="door.need_door_install"> установка двери</span>
                    </h6>
                </div>

            </div>

            <div class="row d-flex align-items-center">
                <div class="col-5 col-md-5 col-lg-5 col-xl-5 d-flex justify-content-center mt-2">
                    <button class="btn btn-link px-2"
                            type="button"
                            style="color: black;"
                            @click="changeQuantityProductInCart('decrement')">
                        <i class="fas fa-minus"></i>
                    </button>

                    <span class="btn" style="color: black;">{{ quantity }}</span>

                    <button class="btn btn-link px-2"
                            type="button"
                            style="color: black;"
                            @click="changeQuantityProductInCart('increment')">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="col-5 col-md-5 col-lg-5 col-xl-5">
                    <h6 class="mb-0 text-center font-bold">{{ quantity * (door.price || 0) }} ₽</h6>
                </div>
                <div class="col-2 col-md-2 col-lg-2 col-xl-2 text-center">
                    <a href="javascript:void(0)"
                       @click="removeProduct"
                       class="text-muted"><i class="fas fa-times"></i></a>
                </div>
                <div class="col-12">
                    <button
                        type="button"
                        style="color: black;"
                        class="btn btn-link"
                        @click="editDoorItem"><i class="fa-regular fa-pen-to-square mr-2"></i>Редактировать
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["item"],
    data() {
        return {
            door: null,
            quantity: 0,
        }
    },
    mounted() {
        this.door = this.item.product || this.item.door || null
        this.quantity = this.item.quantity || this.item.count || 0
    },
    methods: {
        editDoorItem() {
            window.dispatchEvent(new CustomEvent("select-door-item", {
                detail: {
                    item: this.item,
                }
            }));
        },
        removeProduct() {
            this.$store.dispatch("removeProduct", this.door.id)
        },
        changeQuantityProductInCart(direction = "increment") {
            let quantity = direction === "increment" ? this.quantity + 1 : this.quantity - 1;

            if (quantity === 0) {
                this.$store.dispatch("removeProduct", this.door.id)
                return;
            }

            this.$store.dispatch("setQuantity", {
                id: this.door.id,
                quantity: quantity
            })
        }
    }
}
</script>
