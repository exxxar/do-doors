<script setup>
import CartProductItem from '@/Components/Cart/CartProductItem.vue'
</script>
<template>

    <div class="container h-100">
        <form v-on:submit.prevent="goToCheckout" class="row g-0">
            <div class="col-lg-8">
                <div class="p-5">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <h1 class="fw-bold mb-0 text-black">Позиций товаров в корзине</h1>
                        <h6 class="mb-0 text-muted">{{ (cartProducts || []).length }} ед.</h6>
                    </div>
                    <hr class="my-4">


                    <div v-for="item in cartProducts">
                        <CartProductItem :item="item"></CartProductItem>
                        <hr class="my-4">
                    </div>


                    <div class="pt-5">
                        <h6 class="mb-0"><a href="#!" class="text-body"><i
                            class="fas fa-long-arrow-alt-left me-2"></i>К калькулятору</a></h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 bg-grey">
                <div class="p-5">
                    <h3 class="fw-bold mb-5 mt-2 pt-1">Суммарно</h3>
                    <hr class="my-4">

                    <div class="d-flex justify-content-between mb-4">
                        <h5 class="text-uppercase">в корзине {{cartTotalCount}} ед.</h5>
                        <h5>{{cartTotalPrice}}р.</h5>
                    </div>

                    <h5 class="text-uppercase mb-3">Shipping</h5>

                    <div class="mb-4 pb-2">
                        <select class="select">
                            <option value="1">Standard-Delivery- €5.00</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="4">Four</option>
                        </select>
                    </div>

                    <h5 class="text-uppercase mb-3">Give code</h5>

                    <div class="mb-5">
                        <div class="form-outline">
                            <input type="text" id="form3Examplea2" class="form-control form-control-lg"/>
                            <label class="form-label" for="form3Examplea2">Enter your code</label>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between mb-5">
                        <h5 class="text-uppercase fw-bold">Итого сумма</h5>
                        <h5 class="fw-bold">{{cartTotalPrice}} ₽</h5>
                    </div>

                    <button  class="btn btn-success w-100 btn-block btn-lg">
                        Перейти к оформлению
                    </button>

                </div>
            </div>
        </form>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    computed: {
        ...mapGetters(['getErrors', 'cartTotalCount', 'cartProducts','cartTotalPrice']),

    },
    methods:{
        goToCheckout(){
            this.$emit("callback")
        }
    }
}
</script>
