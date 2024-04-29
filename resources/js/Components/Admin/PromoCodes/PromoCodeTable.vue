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
                           class="form-control" id="search-promo-codes">
                    <label

                        for="search-promo-codes">Поиск по промокодам</label>
                </div>
                <button type="button"
                        @click="sortAndLoad('id')"
                        class="btn btn-outline-secondary rounded-0">
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
                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('code')">Код
                    <span v-if="sort.direction === 'desc'&&sort.column === 'code'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'code'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('discount')">Процент скидки
                    <span v-if="sort.direction === 'desc'&&sort.column === 'discount'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'discount'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>
                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('description')">Описание
                    <span v-if="sort.direction === 'desc'&&sort.column === 'description'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'description'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>
                <th scope="col" class="text-center">Число активация</th>
                <th scope="col" class="text-center">Активный</th>
                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('end_at')">
                    Дата окончания
                    <span v-if="sort.direction === 'desc'&&sort.column === 'end_at'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'end_at'"><i
                        class="fa-solid fa-caret-up"></i></span>
                </th>
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
                <td class="text-center" @click="selectItem(item)">
                    {{ item.code || '-' }}
                </td>
                <td class="text-center">
                    {{ item.discount || 0 }}
                </td>
                <td class="text-center ">
                    {{ item.description || 0 }}
                </td>
                <td class="text-center">
                    {{ item.activation_count || 0 }}
                </td>
                <td class="text-center">
                   <span v-if="item.is_active">Активный</span>
                   <span v-else>Не активный</span>

                </td>

                <td class="text-center">
                    {{ item.end_at || '-' }}
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
    </div>
    <div class="alert alert-success rounded-0" role="alert" v-if="items.length===0">
        <h4 class="alert-heading">Промокоды</h4>
        <p>К сожалению, раздел промокодов пуст. Вы еще не добавили ни одного промокода, которые можно отобразить на этой
            странице.</p>
        <hr>
        <p class="mb-0">Воспользуйтесь формой выше и добавьте свой первый промокод</p>
    </div>
    <div class="row mb-3" v-if="items.length>0">
        <div class="col-12">
            <Pagination
                v-on:pagination_page="loadPromoCodes"
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
        ...mapGetters(['getPromoCodes', 'getPromoCodesPaginateObject']),
    },
    mounted() {
        this.loadPromoCodes();
    },
    methods: {
        sortAndLoad(column) {
            this.sort.column = column
            this.sort.direction = this.sort.direction === "desc" ? "asc" : "desc"
            this.loadPromoCodes(this.current_page)
        },

        loadPromoCodes(page = 0) {
            this.current_page = page
            this.$store.dispatch("loadPromoCodes", {
                dataObject: {
                    search: this.search,
                    order: this.sort.column,
                    direction: this.sort.direction
                },
                page: this.current_page
            }).then(resp => {
                this.items = this.getPromoCodes
                this.paginate_object = this.getPromoCodesPaginateObject

            }).catch(() => {
                this.loading = false
            })
        },
        selectItem(item) {
            this.$emit("select", item)
        },
        duplicateItem(id) {
            this.$store.dispatch("duplicatePromoCode", {
                promoCodeId: id
            }).then(() => {
                this.sortAndLoad("id")
            })
        },
        removeItem(id) {
            this.$store.dispatch("removePromoCode", {
                promoCodeId: id
            }).then(() => {
                this.sortAndLoad("id")
            })
        },

    }
}
</script>
