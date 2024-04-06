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
                           class="form-control" id="search-handles">
                    <label

                        for="search-handles">Поиск по ручкам</label>
                </div>
                <button type="button"
                        @click="sortAndLoad('id')"
                        class="btn btn-outline-primary">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>


        </div>
    </form>
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

            <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('price')">Цена
                <span v-if="sort.direction === 'desc'&&sort.column === 'price'"><i
                    class="fa-solid fa-caret-down"></i></span>
                <span v-if="sort.direction === 'asc'&&sort.column === 'price'"><i
                    class="fa-solid fa-caret-up"></i></span>

            </th>
            <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('color')">Цвет
                <span v-if="sort.direction === 'desc'&&sort.column === 'color'"><i
                    class="fa-solid fa-caret-down"></i></span>
                <span v-if="sort.direction === 'asc'&&sort.column === 'color'"><i
                    class="fa-solid fa-caret-up"></i></span>

            </th>
            <th scope="col" class="text-center">Варианты ручек</th>

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
            <td class="text-center" >
                {{ item.price || 0 }}
            </td>
            <td class="text-center d-flex justify-center">
                <span
                    v-if="item.color"
                    class="d-block shadow-md"
                    v-bind:style="{'background-color': item.color}"
                    style="width: 50px; height: 50px;"></span>
                <span v-else>Цвет не указан</span>
            </td>
            <td class="text-center">
                {{ item.variants.length }}

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
    <div class="alert alert-success" role="alert" v-if="items.length===0">
        <h4 class="alert-heading">Ручки</h4>
        <p>К сожалению, раздел ручек пуст. Вы еще не добавили ни одной ручки, которые можно отобразить на этой
            странице.</p>
        <hr>
        <p class="mb-0">Воспользуйтесь формой выше и добавьте свою первую ручку</p>
    </div>
    <div class="row mb-3" v-if="items.length>0">
        <div class="col-12">
            <Pagination
                v-on:pagination_page="loadHandles"
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
                    price: 0,
                  variants: [],

                }
            ]
        }
    },
    computed: {
        ...mapGetters(['getHandles', 'getHandlesPaginateObject']),
    },
    mounted() {
        this.loadHandles();
    },
    methods: {
        sortAndLoad(column) {
            this.sort.column = column
            this.sort.direction = this.sort.direction === "desc" ? "asc" : "desc"
            this.loadHandles(this.current_page)
        },

        loadHandles(page = 0) {
            this.current_page = page
            this.$store.dispatch("loadHandles", {
                dataObject: {
                    search: this.search,
                    order: this.sort.column,
                    direction: this.sort.direction
                },
                page: this.current_page
            }).then(resp => {
                this.items = this.getHandles
                this.paginate_object = this.getHandlesPaginateObject

            }).catch(() => {
                this.loading = false
            })
        },
        selectItem(item) {
            this.$emit("select", item)
        },
        duplicateItem(id) {
            this.$store.dispatch("duplicateHandle", {
                materialId: id
            }).then(() => {
                this.sortAndLoad("id")
            })
        },
        removeItem(id) {
            this.$store.dispatch("removeHandle", {
                materialId: id
            }).then(() => {
                this.sortAndLoad("id")
            })
        },

    }
}
</script>
