<template>
    <div class="row mb-4 d-flex justify-content-between align-items-center">
        <div class="col-md-5 col-lg-5 col-xl-5">
            <h6 class="text-muted font-bold">
                {{item.product.purpose || 'Дверь'}}:
                {{shortDoorTitle}} {{ item.product.width }}x{{ item.product.height }}x
                {{ item.product.opening_type?.depth || 0 }}
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
<!--        {{item.product}}-->
        <div class="col-md-3 col-lg-3 col-xl-3 d-flex">
            <button class="btn btn-outline-secondary rounded-0 px-2"
                    type="button"
                    @click="changeQuantityProductInCart('decrement')">
                <i class="fas fa-minus"></i>
            </button>

            <input id="form1" min="0" name="quantity" :value="item.quantity"
                   type="text" readonly
                   class="form-control form-control-sm text-center border-none rounded-md"/>

            <button class="btn btn-dark rounded-0 px-2"
                    type="button"
                    @click="changeQuantityProductInCart('increment')">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
            <h6 class="mb-0">{{ item.quantity * (item.product.price || 0) }} ₽</h6>
        </div>
        <div class="col-md-1 col-lg-1 col-xl-1 text-end">
            <a href="javascript:void(0)"
               @click="removeProduct"
               class="text-muted"><i class="fas fa-times"></i></a>
        </div>
    </div>
</template>
<script>
import {mapGetters} from "vuex";

export default {
    props: ["item"],
    computed: {
        ...mapGetters(['getDictionary']),
        shortDoorTitle() {
            let key = this.item.product.door_type?.title || 'КДС'
            const abbreviations = {
                "Комплект двери скрытого монтажа": "КДС",
            };

            return abbreviations[key] || key;
        },
    },
    methods: {
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
