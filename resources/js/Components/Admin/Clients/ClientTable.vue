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
                           class="form-control" id="search-clients">
                    <label

                        for="search-clients">Поиск по клиентам</label>
                </div>
                <button type="button"
                        @click="sortAndLoad('id')"
                        class="btn btn-outline-secondary rounded-0">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>


        </div>
    </form>
    <div class="d-flex scrollable-area py-5 mb-3">
        <table class="table table-responsive" v-if="items.length>0">
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
                 <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('title')"> ФИО
                    <span v-if="sort.direction === 'desc'&&sort.column === 'fio'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'fio'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('phone')">Телефон
                    <span v-if="sort.direction === 'desc'&&sort.column === 'phone'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'phone'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('status')">Статус клиента
                    <span v-if="sort.direction === 'desc'&&sort.column === 'status'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'status'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('fact_address')">Фактический
                    адрес
                    <span v-if="sort.direction === 'desc'&&sort.column === 'fact_address'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'fact_address'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('law_address')">Юридический адрес
                    <span v-if="sort.direction === 'desc'&&sort.column === 'law_address'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'law_address'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('inn')">ИНН
                    <span v-if="sort.direction === 'desc'&&sort.column === 'inn'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'inn'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('kpp')">КПП
                    <span v-if="sort.direction === 'desc'&&sort.column === 'kpp'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'kpp'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('ogrn')">ОГРН
                    <span v-if="sort.direction === 'desc'&&sort.column === 'ogrn'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'ogrn'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('okpo')">ОКПО
                    <span v-if="sort.direction === 'desc'&&sort.column === 'okpo'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'okpo'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('comment')">Комментарий
                    <span v-if="sort.direction === 'desc'&&sort.column === 'comment'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'comment'"><i
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
                    {{ item.title || '-' }}
                </td>
                <td class="text-center" @click="selectItem(item)">
                    {{ item.fio || '-' }}
                </td>
                <td class="text-center">
                    {{ item.phone || '-' }}
                </td>

                <td class="text-center">
                    {{ preparedLawStatus(item.status) || '-' }}
                </td>

                <td class="text-center">
                    {{ item.fact_address || '-' }}
                </td>

                <td class="text-center">
                    {{ item.law_address || '-' }}
                </td>

                <td class="text-center">
                    {{ item.inn || '-' }}
                </td>

                <td class="text-center">
                    {{ item.kpp || '-' }}
                </td>

                <td class="text-center">
                    {{ item.ogrn || '-' }}
                </td>

                <td class="text-center">
                    {{ item.okpo || '-' }}
                </td>

                <td class="text-center">
                    {{ item.comment || '-' }}
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
        <h4 class="alert-heading">Клиенты</h4>
        <p>К сожалению, раздел клиентов пуст. Вы еще не добавили ни одного клиента, которых можно отобразить на этой
            странице.</p>
        <hr>
        <p class="mb-0">Воспользуйтесь формой выше и добавьте своего первого клиента</p>
    </div>
    <div class="row mb-3" v-if="items.length>0">
        <div class="col-12">
            <Pagination
                v-on:pagination_page="loadClients"
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
            statuses: [

            ],
            items: [
                {
                    id: null,
                    status: null,
                    phone: null,
                    email: null,
                    fact_address: null,
                    comment: null,
                    user_id: null,
                    title: null,
                    fio: null,
                    law_address: null,
                    inn: null,
                    kpp: null,
                    ogrn: null,
                    okpo: null,
                    requisites: []

                }
            ]
        }
    },
    computed: {
        ...mapGetters(['getClients', 'getClientsPaginateObject',"getDictionary"]),

    },
    mounted() {
        this.loadClients();
        this.statuses = this.getDictionary.statuses || []
    },
    methods: {
        preparedLawStatus(item) {
            let status = this.statuses.find(s => s.value === item) || null
            return status ? status.title : null
        },
        sortAndLoad(column) {
            this.sort.column = column
            this.sort.direction = this.sort.direction === "desc" ? "asc" : "desc"
            this.loadClients(this.current_page)
        },

        loadClients(page = 0) {
            this.current_page = page
            this.$store.dispatch("loadClients", {
                dataObject: {
                    search: this.search,
                    order: this.sort.column,
                    direction: this.sort.direction
                },
                page: this.current_page
            }).then(resp => {
                this.items = this.getClients
                this.paginate_object = this.getClientsPaginateObject

            }).catch(() => {
                this.loading = false
            })
        },
        selectItem(item) {
            this.$emit("select", item)
        },
        duplicateItem(id) {
            this.$store.dispatch("duplicateClient", {
                materialId: id
            }).then(() => {
                this.sortAndLoad("id")
            })
        },
        removeItem(id) {
            this.$store.dispatch("removeClient", {
                materialId: id
            }).then(() => {
                this.sortAndLoad("id")
            })
        },

    }
}
</script>
<style>
.scrollable-area {
    width: 100%;
    overflow-y: auto;
}

</style>
