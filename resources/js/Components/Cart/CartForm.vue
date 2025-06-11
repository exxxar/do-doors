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
                <template v-if="step===0">
                    <div class="d-flex justify-content-between mb-2">
                        <label for="send-to-mail" class="d-flex">
                            <button
                                type="button"
                                id="send-to-mail"
                                v-bind:class="{'btn-outline-secondary':action.indexOf(1)!==-1}"
                                class="btn btn-outline-light text-gray-400 rounded-0 mr-2"
                                @click="preCheckAction(1)">
                                <i
                                    v-if="action.indexOf(1)!==-1"
                                    v-bind:class="{'text-success':action.indexOf(1)!==-1}"
                                    class="fa-solid fa-check-double"></i>

                                <i v-else class="fa-solid fa-check"></i>

                            </button>

                            <span>
                                     Отправить КП на почту клиента и в телеграм
                                </span>


                        </label>

                        <button
                            :disabled="action.indexOf(1)===-1"
                            @click="checkout(3)"
                            class="btn btn-dark rounded-0 ml-2"><i class="fa-solid fa-paper-plane"></i></button>
                    </div>

                    <button class="btn btn-success rounded-0 w-100 mb-2" @click="checkout(0)">Отправить сделку в СРМ
                    </button>

                    <button class="btn btn-outline-dark  rounded-0 w-100 mb-2" @click="checkout(3)"><i
                        class="fa-solid fa-floppy-disk"></i> Сохранить
                    </button>
                </template>

                <template v-if="step===1">

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
                        v-on:callback="back"></CartCheckoutForm>
                </template>



<!--                <CartResultForm
                    :disabled="timer"
                    v-model="clientForm">
                    <template #loader>
                        <div
                            v-if="timer"
                            class="d-flex justify-content-center my-3">
                            <div class="spinner-border text-primary mx-2" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            Отправляем...
                        </div>
                    </template>
                </CartResultForm>-->
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
            step:0,
            action: [],
        }
    },
    methods: {
        checkout(action) {
            this.step = 1
            this.tab = 1
            this.preCheckAction(action)
        },
        preCheckAction(action) {
            let index = this.action.findIndex(item => item === action)

            if (index !== -1) {
                this.action.splice(index, 1)
                return
            }
            this.action.push(action)
        },
        goToCheckout() {
            this.$emit("callback")
        },
        back() {
            this.step = 0
            this.tab = 0
            //window.location = "/dashboard"
        }
    }
}
</script>
