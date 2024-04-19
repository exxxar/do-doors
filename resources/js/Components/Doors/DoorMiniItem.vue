<template>
    <div class="card mb-2 rounded-0">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="text-muted font-bold">{{item.product.door_type.title}} {{ item.product.width }}x{{ item.product.height }}x{{ item.product.depth }}
                    </h6>
                    <h6 class="text-black mb-0">
                        <span v-if="item.product.box_and_frame_color.title">({{item.product.box_and_frame_color.title}})</span> лицо
                        <span class="ml-1" v-if="item.product.front_side_finish.title">{{item.product.front_side_finish.title}} </span>/
                        <span class="ml-1" v-if="item.product.back_side_finish.title">{{item.product.back_side_finish.title}},</span>
                        петли <span v-if="item.product.loops.title">{{item.product.loops.title}},</span>
                        <span class="ml-1" v-if="item.product.hinge_manufacturer.title ">{{item.product.hinge_manufacturer.title}},</span>
                        <span class="ml-1" v-if="item.product.fittings_color.title">({{item.product.fittings_color.title}}),</span>
                        <span class="ml-1" v-if="item.product.opening_type.title"> {{item.product.opening_type.title}},</span>
                        <span class="ml-1" v-if="item.product.handle_holes.title"> {{item.product.handle_holes.title}},</span>
                        <span class="ml-1" v-if="item.product.need_automatic_doorstep"> автоматический порожек,</span>
                        <span class="ml-1" v-if="item.product.need_upper_jumper"> верхняя перемычка,</span>
                        <span class="ml-1" v-if="item.product.need_handle_holes"> дверная ручка,</span>
                        <span class="ml-1" v-if="item.product.handle_holes_type.title"> {{ item.product.handle_holes_type.title }},</span>
                        <span class="ml-1" v-if="item.product.handle_holes.title"> {{ item.product.handle_holes.title }},</span>
                        <span class="ml-1" v-if="item.product.need_hidden_door_closer"> скрытый доводчик,</span>
                        <span class="ml-1" v-if="item.product.need_hidden_skirting_board"> скрытый плинтус,</span>
                        <span class="ml-1" v-if="item.product.need_hidden_stopper"> скрытый стопор,</span>
                        <span class="ml-1" v-if="item.product.need_door_install"> установка двери</span>
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

                    <span class="btn"  style="color: black;">{{item.quantity}}</span>

                    <button class="btn btn-link px-2"
                            type="button"
                            style="color: black;"
                            @click="changeQuantityProductInCart('increment')">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="col-5 col-md-5 col-lg-5 col-xl-5">
                    <h6 class="mb-0 text-center font-bold">{{ item.quantity * (item.product.price || 0) }} ₽</h6>
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
                        @click="editDoorItem"><i class="fa-regular fa-pen-to-square mr-2"></i>Редактировать</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:["item"],
    methods: {
        editDoorItem(){
            window.dispatchEvent(new CustomEvent("select-door-item", {
                detail: {
                    item: this.item,
                }
            }));
        },
        removeProduct(){
            this.$store.dispatch("removeProduct", this.item.product.id)
        },
        changeQuantityProductInCart(direction = "increment") {
            let quantity = direction === "increment" ? this.item.quantity + 1 : this.item.quantity - 1;

            if (quantity===0)
            {
                this.$store.dispatch("removeProduct", this.item.product.id)
                return;
            }

            this.$store.dispatch("setQuantity", {
                id: this.item.product.id,
                quantity: quantity
            })
        }
    }
}
</script>
