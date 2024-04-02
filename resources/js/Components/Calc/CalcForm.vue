<script setup>
import DoorItemEditor from "@/Components/Doors/DoorItemEditor.vue";
import DoorMiniItem from "@/Components/Doors/DoorMiniItem.vue";
import RalColorSelector from "@/Components/Support/RalColorSelector.vue";
import DoorPreview from "@/Components/Doors/DoorPreview.vue";
</script>
<template>

    <div class="row">
        <div class="col-md-6 col-lg-3  col-12">
            <button
                type="button"
                @click="clearForm"
                class="btn btn-outline-success rounded-5 my-3 w-100">Очистить форму
            </button>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">
            <DoorItemEditor
                v-if="!loading"
                :door="selectedDoor"></DoorItemEditor>
        </div>


<!--        <div class="col-lg-3">
            <h6 class="font-bold mb-5">Все двери</h6>
            <div style="overflow-y: auto; width: 100%; height: 100%;">
                <DoorMiniItem :item="item" v-for="item in cartProducts"></DoorMiniItem>
            </div>
        </div>-->
    </div>

<!--    <div style="overflow-x: scroll; width: 100%; height: 100vh;">
        <div class="d-flex" style="min-width: 10000px;">
           <div class="card mr-2"
                style="width: 500px;"
                v-for="(item, index) in cartProducts">
               <div class="card-header">
                   <p>Дверь {{index+1}}</p>
               </div>
               <div class="card-body">
                   <DoorItemEditor

                       :door="item"></DoorItemEditor>
               </div>

           </div>


        </div>

    </div>-->


    <!-- Modal -->
    <div class="modal fade" id="choose-color" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Выбор цвета RAL</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <RalColorSelector v-on:select="selectColor"></RalColorSelector>

                </div>

            </div>
        </div>
    </div>


    <!-- Modal -->
<!--
    <div class="modal fade" id="choose-image" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <img :src="item.path" alt=""  v-if="(doorForm.back_side_finish.door_variants||[]).length>0" v-for="item in (doorForm.back_side_finish.door_variants||[])">


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
-->

</template>
<script>

import {mapGetters} from "vuex";

export default {
    name: 'MyComponent',
    data() {
        return {
            loading:false,
            messages: [],
            selectedColor:null,
            selectedDoor:null,

        }
    },
    computed: {
        ...mapGetters(['getErrors', 'getDictionary', 'cartTotalCount', 'cartProducts', 'cartTotalPrice']),
        summaryPriceWithDealer() {
            return Math.round(this.summaryPrice * (1 + ((this.doorForm.dealer_percent || 0) / 100)))
        },


        summaryPrice() {
            let sum = 0;


            Object.keys(this.doorForm).forEach(item => {

                if (item) {

                    if (typeof this.doorForm[item] === "object" && this.doorForm[item] != null) {
                        sum += (this.doorForm[item].price || 0)
                    }
                }

            })

            return sum;
        },
    },


    mounted() {

        window.addEventListener("select-door-item", (e) => {
            this.selectedDoor = e.detail.item || null

            this.loading = true

            this.$nextTick(()=>{
                this.loading = false

                this.$notify({
                    title: "DoDoors",
                    text: "Вы выбрали дверь для редактирования",
                });
            })


        } );

        this.$store.dispatch("loadFormattedSizes").then(resp => {

        }).catch(() => {

        })
    },
    methods: {
        selectColor(item){
            this.selectedColor = item.color.hex
        },
        clearForm(){
            this.loading = true

            this.selectedDoor = null

            this.$nextTick(()=>{
                this.loading = false
            })

            this.$notify({
                title: "DoDoors",
                text: "Форма очищена",
            });
        }
    }
}
</script>
<style lang="scss">

.scroll-area {
    position: relative;
    margin: auto;
    width: 400px;
    height: 300px;
}

.door-image {
    max-width: 200px;

    img {
        object-fit: cover;
    }
}

.door-wrapper {
    width: 500px;
    min-height: 589px;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: end;
    background: #f1e1df;
    .back-image {
        top: 0px;
        left: 0px;
        position: absolute;
        object-fit: cover;
        z-index: 0;
    }

    .front-image {
        position: absolute;
        object-fit: cover;
        z-index: 1;
    }
}
</style>
