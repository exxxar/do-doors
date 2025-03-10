<script setup>
import Pagination from "@/Components/Pagination.vue";
import PermissionForm from "@/Components/Admin/Permissions/PermissionForm.vue";
</script>
<template>
    <form class="row">
        <div class="col-12">

            <div class="input-group mb-3">
                <div class="form-floating">
                    <input type="search"
                           v-model="search"
                           class="form-control" id="search-permissions">
                    <label

                        for="search-permissions">Поиск по разрешениям</label>
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
                <th scope="col"
                    v-if="!forSelect"
                    class="text-center">Действие</th>
                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('name')">Название
                    <span v-if="sort.direction === 'desc'&&sort.column === 'name'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'name'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col"
                    class="text-center cursor-pointer" @click="sortAndLoad('slug')">Идентификатор
                    <span v-if="sort.direction === 'desc'&&sort.column === 'slug'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'slug'"><i
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
                <td class="text-center cursor-pointer" @click="selectItem(item)">
                    <i class="fa-solid fa-lock mr-2 color-danger" v-if="(selected||[]).indexOf(item.id)!==-1"></i> {{ item.name || '-' }}
                </td>
                <td class="text-center">
                    {{ item.slug || '-' }}
                </td>

                <td class="text-center"  v-if="!forSelect">
                    {{ item.updated_at || '-' }}
                </td>

            </tr>

            </tbody>
        </table>
    </div>
    <div class="alert alert-success rounded-0" role="alert" v-if="items.length===0">
        <h4 class="alert-heading">Разрешения пользователей</h4>
        <p>К сожалению, раздел ролей пуст. Вы еще не добавили ни одной роли, которые можно отобразить на этой
            странице.</p>
        <hr>
        <p class="mb-0">Воспользуйтесь формой выше и добавьте свою первую роль</p>
    </div>
    <div class="row mb-3" v-if="items.length>0">
        <div class="col-12">
            <Pagination
                v-on:pagination_page="loadPermissions"
                v-if="paginate_object"
                :pagination="paginate_object"/>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="permission-editor-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content rounded-0">

                <div class="modal-body ">
                    <template v-if="selected_item">
                        <PermissionForm
                            :item="selected_item"
                            v-on:callback="selectItem(null)"></PermissionForm>
                    </template>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
import {mapGetters} from "vuex";

export default {
    props:["forSelect","selected"],
    data() {
        return {
            sort: {
                column: null,
                direction: "desc"
            },
            search: null,
            editor_modal: null,
            selected_item: null,
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
        ...mapGetters(['getPermissions', 'getPermissionsPaginateObject']),
    },
    mounted() {
        this.loadPermissions();

        this.editor_modal = new bootstrap.Modal(document.getElementById('permission-editor-modal'), {})
    },
    methods: {
        sortAndLoad(column) {
            this.sort.column = column
            this.sort.direction = this.sort.direction === "desc" ? "asc" : "desc"
            this.loadPermissions(this.current_page)
        },

        loadPermissions(page = 0) {
            this.current_page = page
            this.$store.dispatch("loadPermissions", {
                dataObject: {
                    search: this.search,
                    order: this.sort.column,
                    direction: this.sort.direction
                },
                page: this.current_page
            }).then(resp => {
                this.items = this.getPermissions
                this.paginate_object = this.getPermissionsPaginateObject

            }).catch(() => {
                this.loading = false
            })
        },
        selectItem(item) {
           // this.$emit("select", item)

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
            this.$store.dispatch("duplicatePermission", {
                permissionId: id
            }).then(() => {
                this.sortAndLoad("id")
            })
        },
        removeItem(id) {
            this.$store.dispatch("removePermission", {
                permissionId: id
            }).then(() => {
                this.sortAndLoad("id")
            })
        },

    }
}
</script>
