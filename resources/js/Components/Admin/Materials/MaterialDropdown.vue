<script setup>
import Pagination from "@/Components/Pagination.vue";
</script>
<template>

    <div class="dropdown">
        <button class="btn btn-outline-secondary w-100 p-3" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
            <slot></slot>
        </button>
        <div class="dropdown-menu w-100">
            <div class="px-4 py-3">
                <div class="form-floating mb-3">
                    <input type="search"
                           v-model="search"
                           @keyup="sortAndLoad('id')"
                           class="form-control" id="search-materials">
                    <label
                        for="search-materials">Поиск по материалам</label>
                </div>

                <div class="list-group" v-if="items.length>0">
                    <a href="javascript:void(0)"
                       @click="selectItem(item)"
                       v-for="(item, index) in items"
                       class="list-group-item list-group-item-action" aria-current="true">
                        {{item.title || '-'}}
                    </a>
                </div>

                <div class="alert alert-success" role="alert" v-if="items.length===0">
                   <p>Ничего не найдено</p>
                </div>

                <Pagination
                    class="my-3"
                    v-on:pagination_page="loadMaterials"
                    v-if="paginate_object&&items.length>0"
                    :pagination="paginate_object"/>

            </div>
        </div>
    </div>




</template>
<script>
import {mapGetters} from "vuex";

export default {
    data() {
        return {
            sort: {
                column: null,
                direction: "desc"
            },
            search: null,
            current_page: 0,
            paginate_object: null,
            items: [
                {
                    id: null,
                    title: null,
                    wrapper_variants: [],
                    door_variants: []
                }
            ]
        }
    },
    computed: {
        ...mapGetters(['getMaterialsPaginateObject', 'getMaterials']),
    },
    mounted() {
        this.loadMaterials();
    },
    methods: {
        sortAndLoad(column) {
            this.sort.column = column
            this.sort.direction = this.sort.direction === "desc" ? "asc" : "desc"
            this.loadMaterials(this.current_page)
        },

        loadMaterials(page = 0) {
            this.current_page = page
            this.$store.dispatch("loadMaterials", {
                dataObject: {
                    search: this.search,
                    order: this.sort.column,
                    direction: this.sort.direction
                },
                page: this.current_page
            }).then(resp => {
                this.items = this.getMaterials
                this.paginate_object = this.getMaterialsPaginateObject

            }).catch(() => {
                this.loading = false
            })
        },
        selectItem(item) {
            this.$emit("select", item)
        },


    }
}
</script>
