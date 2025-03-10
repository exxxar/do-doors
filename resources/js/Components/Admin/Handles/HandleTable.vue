<script setup>
import Pagination from "@/Components/Pagination.vue";
import HandleForm from "@/Components/Admin/Handles/HandleForm.vue";
import HandleDetail from "@/Components/Admin/Handles/HandleDetail.vue";

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
                <th scope="col" class="text-center">Действие</th>
                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('title')">Название
                    <span v-if="sort.direction === 'desc'&&sort.column === 'title'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'title'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('price')">Цена, ₽
                    <span v-if="sort.direction === 'desc'&&sort.column === 'price'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'price'"><i
                        class="fa-solid fa-caret-up"></i></span>

                    <table class="w-100">
                        <thead>
                        <th style="width: 100px;">опт</th>
                        <th style="width: 100px;">дилер</th>
                        <th style="width: 100px;">розница</th>
                        <th style="width: 100px;">себестоимость</th>
                        </thead>
                    </table>

                </th>
                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('color')">Цвет
                    <span v-if="sort.direction === 'desc'&&sort.column === 'color'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'color'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>
                <th scope="col" class="text-center">Изображения к ручке</th>

                <!--                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('updated_at')">
                                    Дата изменения
                                    <span v-if="sort.direction === 'desc'&&sort.column === 'updated_at'"><i
                                        class="fa-solid fa-caret-down"></i></span>
                                    <span v-if="sort.direction === 'asc'&&sort.column === 'updated_at'"><i
                                        class="fa-solid fa-caret-up"></i></span>
                                </th>-->

            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in items">
                <th scope="row">{{ item.id || index }}</th>
                <td class="text-center">
                    <div class="dropdown">
                        <button class="btn btn-link" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                        <ul class="dropdown-menu">


                            <li><a class="dropdown-item"
                                   @click="showDetails(item)"
                                   href="javascript:void(0)"><i class="fa-solid fa-info mr-2"></i>Детали</a></li>

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
                <td class="text-center" @click="selectItem(item)">
                    {{ item.title || '-' }}
                </td>
                <td class="text-center">
                    <table class="w-100">
                        <tbody>
                        <tr>
                            <td style="width: 100px; text-align: center;">{{ items[index].price.wholesale || 0 }}</td>
                            <td style="width: 100px; text-align: center;">{{ items[index].price.dealer || 0 }}</td>
                            <td style="width: 100px; text-align: center;">{{ items[index].price.retail || 0 }}</td>
                            <td style="width: 100px; text-align: center;">{{ items[index].price.cost || 0 }}</td>
                        </tr>
                        </tbody>
                    </table>
                </td>
                <td class="text-center ">

                    <div class="d-flex justify-center flex-column align-items-center">
                        <p>{{ item.color ?? '-' }}</p>
                        <span
                            v-if="isHex(item.color)"
                            class="d-block shadow-md mt-1"
                            v-bind:style="{'background-color': item.color}"
                            style="width: 50px; height: 50px;"></span>
                    </div>

                </td>
                <td class="text-center">
                    {{ item.variants.length }}

                </td>


                <!--                <td class="text-center">
                                    {{ item.updated_at || '-' }}
                                </td>-->

            </tr>

            </tbody>
        </table>
    </div>
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

    <!-- Modal -->
    <div class="modal fade" id="show-current-handle-details" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Просмотр деталей</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <template v-if="selectedHandle">
                        <HandleDetail :selected-handle="selectedHandle">
                        </HandleDetail>
                    </template>


                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="handle-editor-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content rounded-0">

                <div class="modal-body ">
                    <template v-if="selected_item">
                        <HandleForm
                            :item="selected_item"
                            v-on:callback="selectItem(null)"></HandleForm>
                    </template>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
import {mapGetters} from "vuex";

export default {
    data() {
        return {
            editor_modal: null,
            selected_item: null,
            selectedHandle: null,
            detailsModal: null,
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
        window.addEventListener("load-handles", () => {
            this.loadHandles();

        })
        this.editor_modal = new bootstrap.Modal(document.getElementById('handle-editor-modal'), {})
        this.detailsModal = new bootstrap.Modal(document.getElementById('show-current-handle-details'), {})

    },
    methods: {
        showDetails(item) {
            this.selectedHandle = null

            this.$nextTick(() => {
                this.selectedHandle = item
                this.detailsModal.show()
            })


        },

        isHex(num) {
            return /^#[0-9A-F]{6}$/i.test(num)
        },
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
            this.$store.dispatch("duplicateHandle", {
                handleId: id
            }).then(() => {
                this.sortAndLoad("id")
            })
        },
        removeItem(id) {
            this.$store.dispatch("removeHandle", {
                handleId: id
            }).then(() => {
                this.sortAndLoad("id")
            })
        },

    }
}
</script>
