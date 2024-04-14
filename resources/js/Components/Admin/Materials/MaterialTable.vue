<script setup>
import Pagination from "@/Components/Pagination.vue";
</script>
<template>
    <form class="row">
        <div class="col-12">

            <div class="input-group mb-3">
                <div class="form-floating">
                    <input type="search"
                           v-model="search"
                           class="form-control" id="search-materials">
                    <label

                        for="search-materials">Поиск по материалам</label>
                </div>
                <button type="button"
                        @click="sortAndLoad('id')"
                        class="btn btn-outline-primary">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>


        </div>
    </form>

    <div style="overflow-y: auto;">
        <table class="table" v-if="items.length>0">
            <thead>
            <tr>
                <th scope="col" class="cursor-pointer" @click="sortAndLoad('id')">#
                    <span v-if="sort.direction === 'desc'&&sort.column === 'id'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'id'"><i
                        class="fa-solid fa-caret-up"></i></span>
                </th>
                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('title')">Название
                    <span v-if="sort.direction === 'desc'&&sort.column === 'title'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'title'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>
                <th scope="col" class="text-center">Варианты двери</th>
                <th scope="col" class="text-center">Варианты контура вокруг</th>
                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('updated_at')">
                    Дата изменения
                    <span v-if="sort.direction === 'desc'&&sort.column === 'updated_at'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'updated_at'"><i
                        class="fa-solid fa-caret-up"></i></span>
                </th>
                <th scope="col" class="text-center">Действие</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in items">
                <th scope="row">{{ item.id || index }}</th>
                <td class="text-center"  @click="selectItem(item)">
                    {{ item.title || '-' }}
                </td>
                <td class="text-center">
                    {{ (item.door_variants||[]).length }}

                </td>
                <td class="text-center">
                    {{ (item.wrapper_variants||[]).length }}

                </td>
                <td class="text-center">
                    {{ item.updated_at || '-' }}
                </td>
                <td class="text-center">
                    <div class="dropdown">
                        <button class="btn btn-link" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item"
                                   @click="selectItem(item)"
                                   href="javascript:void(0)"><i class="fa-solid fa-pen mr-2"></i>Редактировать</a></li>
                            <li><a class="dropdown-item"
                                   @click="duplicateItem(item.id)"
                                   href="javascript:void(0)"><i class="fa-regular fa-copy mr-2"></i>Дублировать</a>
                            </li>
                            <li><a class="dropdown-item text-danger"
                                   @click="removeItem(item.id)"
                                   href="javascript:void(0)"><i class="fa-solid fa-trash-can mr-2"></i>Удалить</a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>

            </tbody>
        </table>
    </div>

    <div class="alert alert-success" role="alert" v-if="items.length===0">
        <h4 class="alert-heading">Материалы</h4>
        <p>К сожалению, раздел материалов пуст. Вы еще не добавили ни одного материала, который можно отобразить на этой
            странице.</p>
        <hr>
        <p class="mb-0">Воспользуйтесь формой выше и добавьте свой первый материал</p>
    </div>
    <div class="row mb-3" v-if="items.length>0">
        <div class="col-12">
            <Pagination
                v-on:pagination_page="loadMaterials"
                v-if="paginate_object"
                :pagination="paginate_object"/>
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
        duplicateItem(id) {
            this.$store.dispatch("duplicateMaterial", {
                materialId: id
            }).then(() => {
                this.sortAndLoad("id")
            })
        },
        removeItem(id) {
            this.$store.dispatch("removeMaterial", {
                materialId: id
            }).then(() => {
                this.sortAndLoad("id")
            })
        },
        showWrapperVariants(item) {
            this.$emit("show-wrapper-variants", item.wrapper_variants)
        },
        showDoorVariants(item) {
            this.$emit("show-door-variants", item.door_variants)
        }
    }
}
</script>
