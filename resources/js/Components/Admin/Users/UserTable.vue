<script setup>
import Pagination from "@/Components/Pagination.vue";
import UserForm from "@/Components/Admin/Users/UserForm.vue";
</script>
<template>
    <form class="row">
        <div class="col-12">

            <div class="input-group mb-3">
                <div class="form-floating">
                    <input type="search"
                           v-model="search"
                           class="form-control" id="search-users">
                    <label

                        for="search-users">Поиск пользователя</label>
                </div>
                <button type="button"
                        @click="sortAndLoad('id')"
                        class="btn btn-outline-secondary rounded-0">
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
                <th scope="col" class="text-center" v-if="!forSelect">Действие</th>
                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('email')">Почта
                    <span v-if="sort.direction === 'desc'&&sort.column === 'email'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'email'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('name')">Имя
                    <span v-if="sort.direction === 'desc'&&sort.column === 'name'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'name'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col"
                    v-if="!forSelect"
                    class="text-center cursor-pointer" @click="sortAndLoad('updated_at')">
                    Дата изменения
                    <span v-if="sort.direction === 'desc'&&sort.column === 'updated_at'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'updated_at'"><i
                        class="fa-solid fa-caret-up"></i></span>
                </th>

            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in items">
                <th scope="row">{{ item.id || index }}</th>
                <td class="text-center" v-if="!forSelect">
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
                <td class="text-center">
                    {{ item.email || '-' }}
                </td>
                <td class="text-center">
                    {{ item.name || 0 }}
                </td>


                <td class="text-center" v-if="!forSelect">
                    {{ item.updated_at || '-' }}
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
                v-on:pagination_page="loadUsers"
                v-if="paginate_object"
                :pagination="paginate_object"/>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="user-editor-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl ">
            <div class="modal-content rounded-0">

                <div class="modal-body ">
                    <template v-if="selected_item">
                        <UserForm
                            :id="'user-form-2'"
                            :item="selected_item"
                            v-on:callback="selectItem(null)"></UserForm>
                    </template>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
import {mapGetters} from "vuex";

export default {
    props:["forSelect"],
    data() {
        return {
            editor_modal: null,
            selected_item: null,
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
        ...mapGetters(['getUsers', 'getUsersPaginateObject']),
    },
    mounted() {
        this.loadUsers();

        this.editor_modal = new bootstrap.Modal(document.getElementById('user-editor-modal'), {})
    },
    methods: {
        sortAndLoad(column) {
            this.sort.column = column
            this.sort.direction = this.sort.direction === "desc" ? "asc" : "desc"
            this.loadUsers(this.current_page)
        },

        loadUsers(page = 0) {
            this.current_page = page
            this.$store.dispatch("loadUsers", {
                dataObject: {
                    search: this.search,
                    order: this.sort.column,
                    direction: this.sort.direction
                },
                page: this.current_page
            }).then(resp => {
                this.items = this.getUsers
                this.paginate_object = this.getUsersPaginateObject

            }).catch(() => {
                this.loading = false
            })
        },
        selectItem(item) {
            //this.$emit("select", item)
            if (item == null) {
                this.selected_item = null
                this.editor_modal.hide()
                return;
            }

            this.selected_item = null
            this.$nextTick(() => {
                this.selected_item = item
                this.editor_modal.show()
            })
        },
        duplicateItem(id) {
            this.$store.dispatch("duplicateUser", {
                materialId: id
            }).then(() => {
                this.sortAndLoad("id")
            })
        },
        removeItem(id) {
            this.$store.dispatch("removeUser", {
                materialId: id
            }).then(() => {
                this.sortAndLoad("id")
            })
        },

    }
}
</script>
