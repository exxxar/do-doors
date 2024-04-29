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
                           class="form-control" id="search-orderDetails">
                    <label

                        for="search-orderDetails">Поиск по деталям заказа</label>
                </div>
                <button type="button"
                        @click="sortAndLoad('id')"
                        class="btn btn-outline-secondary rounded-0">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>


        </div>
    </form>
    <div class="d-flex scrollable-area">
        <table class="table" v-if="items.length>0">
            <thead>
            <tr>
                <th scope="col" class="cursor-pointer" @click="sortAndLoad('id')">#
                    <span v-if="sort.direction === 'desc'&&sort.column === 'id'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'id'"><i
                        class="fa-solid fa-caret-up"></i></span>
                </th>
                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('door_type')">Тип двери
                    <span v-if="sort.direction === 'desc'&&sort.column === 'door_type'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'door_type'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('count')">Кол-во
                    <span v-if="sort.direction === 'desc'&&sort.column === 'count'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'count'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('price')">Цена
                    <span v-if="sort.direction === 'desc'&&sort.column === 'price'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'price'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('comment')">Комментарий
                    <span v-if="sort.direction === 'desc'&&sort.column === 'comment'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'comment'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('purpose')">Назначение двери
                    <span v-if="sort.direction === 'desc'&&sort.column === 'purpose'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'purpose'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('door')">Параметры двери
                    <span v-if="sort.direction === 'desc'&&sort.column === 'door'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'door'"><i
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
                    {{ item.door_type || '-' }}
                </td>
                <td class="text-center">
                    {{ item.count || 0 }}
                </td>
                <td class="text-center">
                    {{ item.price || 0 }}

                </td>

                <td class="text-center">
                    {{ item.comment || '-' }}

                </td>

                <td class="text-center">
                    {{ item.purpose || '-' }}

                </td>

                <td class="text-center">
                    {{ item.door || '-' }}

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

    <div class="alert alert-success" role="alert" v-if="items.length===0">
        <h4 class="alert-heading">Детали заказа</h4>
        <p>К сожалению,в данном заказе нет деталей заказа</p>
    </div>
    <div class="row mb-3" v-if="items.length>0">
        <div class="col-12">
            <Pagination
                v-on:pagination_page="loadOrderDetails"
                v-if="paginate_object"
                :pagination="paginate_object"/>
        </div>
    </div>





</template>
<script>
import {mapGetters} from "vuex";

export default {
    props: ["orderId"],
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
        ...mapGetters(['getOrderDetails', 'getOrderDetailsPaginateObject']),
    },
    mounted() {

        this.loadOrderDetails();
    },
    methods: {

        sortAndLoad(column) {
            this.sort.column = column
            this.sort.direction = this.sort.direction === "desc" ? "asc" : "desc"
            this.loadOrderDetails(this.current_page)
        },

        loadOrderDetails(page = 0) {
            this.current_page = page
            this.$store.dispatch("loadOrderDetails", {
                dataObject: {
                    order_id: this.orderId,
                    search: this.search,
                    order: this.sort.column,
                    direction: this.sort.direction
                },
                page: this.current_page
            }).then(resp => {
                this.items = this.getOrderDetails
                this.paginate_object = this.getOrderDetailsPaginateObject

            }).catch(() => {
                this.loading = false
            })
        },
        selectItem(item) {
            this.$emit("select", item)
        },
        duplicateItem(id) {
            this.$store.dispatch("duplicateOrderDetail", {
                orderDetailId: id
            }).then(() => {
                this.sortAndLoad("id")
            })
        },
        removeItem(id) {
            this.$store.dispatch("removeOrderDetail", {
                orderDetailId: id
            }).then(() => {
                this.sortAndLoad("id")
            })
        },

    }
}
</script>
