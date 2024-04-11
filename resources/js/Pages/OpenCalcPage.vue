<script setup>
import OpenAppLayout from '@/Layouts/OpenAppLayout.vue';
import CalcForm from "@/Components/Calc/CalcForm.vue";
import { Head } from '@inertiajs/vue3';

defineProps({
    params: Object,
});
</script>

<template>
    <OpenAppLayout>
        <div class="container" v-bind:style="{'background-color':settings.bgColor}">
            <div class="row">
                <div class="col-md-12 col-12 d-flex justify-content-center">

                    <div class="card text-bg-dark" style="width: 200px;">
                        <img src="/images/logo.png" class="card-img" alt="...">
                        <div class="card-img-overlay">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <p class="card-text"><small>Выполнить расчет</small></p>
                        </div>
                    </div>

                    <div class="card text-bg-dark" style="width: 200px;">
                        <img src="/images/logo.png" class="card-img" alt="...">
                        <div class="card-img-overlay">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <p class="card-text"><small>Выполнить расчет</small></p>
                        </div>
                    </div>
                </div>


            </div>
            <div class="row" v-if="tab===1">
                <div class="col-12">

                    <CalcForm></CalcForm>
                </div>
            </div>
        </div>
    </OpenAppLayout>
</template>
<script>
export default {
    data(){
        return {
            tab:0,
            settings:{
                bgColor:"white"
            }
        }
    },
    mounted() {
        //форма ввода персональных данных
        //форма оформления заказа
        //расчёт цены + указывать от кого пришел заказ (в ключе)
        if (this.params){
            this.settings.bgColor = this.params.bgColor || "white"
        }
    },
}
</script>
