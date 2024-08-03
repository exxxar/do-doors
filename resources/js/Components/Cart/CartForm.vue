<script setup>
import CartProductItem from '@/Components/Cart/CartProductItem.vue'
import CartCheckoutForm from "@/Components/Cart/CartCheckoutForm.vue";
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
                        <h6 class="mb-0"><a
                            @click="back"
                            href="javascript:void(0)" class="text-body"><i
                            class="fas fa-long-arrow-alt-left me-2"></i>К калькулятору</a></h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 bg-grey">

                <ul class="nav nav-tabs mb-3" id="legal-or-individual-tab" role="tablist">
                    <li class="nav-item"
                        role="presentation">
                        <button
                            class="nav-link rounded-0"
                            v-bind:class="{'active':tab===0}"
                            @click="tab=0"
                            id="home-tab"
                            type="button"
                            aria-controls="legal_entity-tab-pane" aria-selected="true">Юридическое
                            лицо
                        </button>
                    </li>
                    <li class="nav-item"
                        role="presentation">
                        <button
                            v-bind:class="{'active':tab===1}"
                            @click="tab=1"
                            class="nav-link rounded-0"
                            id="profile-tab"
                            type="button" aria-controls="profile-tab-pane" aria-selected="false">Физическое
                            лицо
                        </button>
                    </li>
                </ul>

                <CartCheckoutForm
                    :type="tab"
                    v-on:back="back"></CartCheckoutForm>

            </div>
        </form>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    computed: {
        ...mapGetters(['getErrors', 'cartTotalCount', 'cartProducts', 'cartTotalPrice']),

    },
    data() {
        return {
            tab: 0,
        }
    },
    methods: {

        goToCheckout() {
            this.$emit("callback")
        },
        back() {
            window.location = "/dashboard"
        }
    }
}
</script>
