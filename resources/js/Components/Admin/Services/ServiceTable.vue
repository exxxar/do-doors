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
                           class="form-control" id="search-services">
                    <label

                        for="search-services">Поиск по доступным сервисам</label>
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
                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('title')">Название
                    <span v-if="sort.direction === 'desc'&&sort.column === 'title'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'title'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('description')">Пояснение
                    <span v-if="sort.direction === 'desc'&&sort.column === 'description'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'description'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('type')">Тип сервиса
                    <span v-if="sort.direction === 'desc'&&sort.column === 'type'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'type'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('order_position')">Позиция в
                    выдаче
                    <span v-if="sort.direction === 'desc'&&sort.column === 'order_position'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'order_position'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('is_active')">Отображается в
                    калькуляторе
                    <span v-if="sort.direction === 'desc'&&sort.column === 'is_active'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'is_active'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('price')">Цена
                    <span v-if="sort.direction === 'desc'&&sort.column === 'price'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'price'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>


                <!--                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('updated_at')">
                                    Дата изменения
                                    <span v-if="sort.direction === 'desc'&&sort.column === 'updated_at'"><i
                                        class="fa-solid fa-caret-down"></i></span>
                                    <span v-if="sort.direction === 'asc'&&sort.column === 'updated_at'"><i
                                        class="fa-solid fa-caret-up"></i></span>
                                </th>-->
                <th scope="col" class="text-center">Действие</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in items">
                <th scope="row">{{ item.id || index }}</th>
                <td class="text-center" @click="selectItem(item)">
                    {{ item.title || '-' }}
                </td>

                <td class="text-center">
                    {{ item.description || '-' }}
                </td>

                <td class="text-center">
                    {{ item.type || '-' }}
                </td>

                <td class="text-center">
                    {{ item.order_position || 0 }}
                </td>

                <td class="text-center" style="width: 50px;">
                    {{ item.is_active ? "да" : "нет" }}
                </td>
                <td class="text-center">
                    <table class="w-100">
                        <thead>
                        <th>опт, ₽</th>
                        <th>дилер, ₽</th>
                        <th>розница, ₽</th>
                        <th>себестоимость, ₽</th>
                        </thead>
                        <tbody>
                        <tr>
                            <td style="min-width: 100px; text-align: center;">{{ items[index].price.wholesale || 0 }}
                            </td>
                            <td style="min-width: 100px; text-align: center;">{{ items[index].price.dealer || 0 }}
                            </td>
                            <td style="min-width: 100px; text-align: center;">{{ items[index].price.retail || 0 }}
                            </td>
                            <td style="min-width: 100px; text-align: center;">{{ items[index].price.cost || 0 }}
                            </td>
                        </tr>


                        </tbody>
                    </table>
                </td>


                <!--                <td class="text-center">
                                    {{ item.updated_at || '-' }}
                                </td>-->
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
    <div class="alert alert-success" role="alert" v-if="items.length===0">
        <h4 class="alert-heading">Варианты дверей</h4>
        <p>К сожалению, раздел Варианты дверей пуст. Вы еще не добавили ни одного варианта дверей, которые можно
            отобразить на этой
            странице.</p>
        <hr>
        <p class="mb-0">Воспользуйтесь формой выше и добавьте свой первый вариант дверей</p>
    </div>
    <div class="row mb-3" v-if="items.length>0">
        <div class="col-12">
            <Pagination
                v-on:pagination_page="loadServices"
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
                    price: {
                        wholesale: 0,
                        dealer: 0,
                        retail: 0,
                        cost: 0,
                    },
                    type: null,
                    description: null,
                    is_active: true,
                    order_position: 0,
                }
            ]
        }
    },
    computed: {
        ...mapGetters(['getServices', 'getServicesPaginateObject']),
    },
    mounted() {
        this.loadServices();
    },
    methods: {
        sortAndLoad(column) {
            this.sort.column = column
            this.sort.direction = this.sort.direction === "desc" ? "asc" : "desc"
            this.loadServices(this.current_page)
        },

        loadServices(page = 0) {
            this.current_page = page
            this.$store.dispatch("loadServices", {
                dataObject: {
                    search: this.search,
                    order: this.sort.column,
                    direction: this.sort.direction
                },
                page: this.current_page
            }).then(resp => {
                this.items = this.getServices
                this.paginate_object = this.getServicesPaginateObject

            }).catch(() => {
                this.loading = false
            })
        },
        selectItem(item) {
            this.$emit("select", item)
        },
        duplicateItem(id) {
            this.$store.dispatch("duplicateDoorVariant", {
                doorVariantId: id
            }).then(() => {
                this.sortAndLoad("id")
            })
        },
        removeItem(id) {
            this.$store.dispatch("removeDoorVariant", {
                doorVariantId: id
            }).then(() => {
                this.sortAndLoad("id")
            })
        },

    }
}
</script>
