<script setup>
import CartProductItem from '@/Components/Cart/CartProductItem.vue'
import CartCheckoutForm from "@/Components/Cart/CartCheckoutForm.vue";
import CartCheckoutFormIndividual from "@/Components/Cart/CartCheckoutFormIndividual.vue";
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
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#legal_entity-tab-pane"
                type="button" role="tab" aria-controls="legal_entity-tab-pane" aria-selected="true">Юридическое
                лицо</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#individual-tab-pane"
                type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Физическое
                лицо</button>
        </li>
        </ul>
     <div class="tab-content" id="legal-or-individual-tabContent">
         <div class="tab-pane fade show active" id="legal_entity-tab-pane" role="tabpanel" aria-labelledby="legal_entity">
            <CartCheckoutForm
                    v-on:back="back"></CartCheckoutForm>
         </div>
         <div class="tab-pane fade show" id="individual-tab-pane" role="tabpanel" aria-labelledby="legal_entity">
             <CartCheckoutFormIndividual
                    v-on:back="back"></CartCheckoutFormIndividual>
         </div>
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
        },
        back(){
            window.location = "/dashboard"
        }
    }
}
</script>
