<script setup>
import Pagination from "@/Components/Pagination.vue";
import MaterialDropdown from "@/Components/Admin/Materials/MaterialDropdown.vue";
</script>
<template>
        test
    <div class="d-flex">
        <span v-for="item in materials" class="mr-2">{{item.title}}</span>
    </div>

    <div class="d-flex flex-column" style="width: 100px;">
        <div v-for="item in height" class="mr-2 d-flex justify-between">
            <div>{{ item }}</div>
            <div class="d-flex flex-column">
                <span v-for="sub in width" >
                    {{sub}}
                </span>
            </div>

        </div>
    </div>





</template>
<script>
import {mapGetters} from "vuex";

export default {
    data() {
        return {
            materials:[],
            sizes:[],
            width: [],
            height: []
        }
    },

    mounted() {
        this.loadSizes();


        this.$store.dispatch("loadFormattedSizes").then(resp => {

        }).catch(() => {

        })
    },
    methods: {

        loadSizes(page = 0) {
            this.$store.dispatch("loadFormattedSizes").then(resp => {
                this.width = resp.width
                this.height = resp.height
                this.sizes = resp.sizes
                this.materials = resp.materials


            }).catch(() => {

            })
        },


    }
}
</script>
