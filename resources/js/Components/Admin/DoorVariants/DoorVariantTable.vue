<script setup>
import Pagination from "@/Components/Pagination.vue";
import DoorVariantForm from "@/Components/Admin/DoorVariants/DoorVariantForm.vue";
</script>
<template>
    <form class="row">
        <div class="col-12">

            <div class="input-group mb-3">
                <div class="form-floating">
                    <input type="search"
                           v-model="search"
                           class="form-control" id="search-door-variants">
                    <label

                        for="search-door-variants">Поиск по производителям петель</label>
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

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('need_percent_price')">%
                    <span v-if="sort.direction === 'desc'&&sort.column === 'need_percent_price'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'need_percent_price'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('price')">Цена
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
                <td class="text-center" style="width: 50px;">
                    {{ item.need_percent_price ? "да":"нет" }}
                </td>
                <td class="text-center">
                    <table class="w-100">

                        <tbody>
                        <tr>
                            <td style="width: 100px; text-align: center;">{{items[index].price.wholesale|| 0}}<span v-if="items[index].need_percent_price">, %</span><span v-else>, ₽</span>
                            </td>
                            <td style="width: 100px; text-align: center;" >{{items[index].price.dealer|| 0}}<span v-if="items[index].need_percent_price">, %</span><span v-else>, ₽</span>
                            </td>
                            <td style="width: 100px; text-align: center;">{{items[index].price.retail|| 0}}<span v-if="items[index].need_percent_price">, %</span><span v-else>, ₽</span>
                            </td>
                            <td style="width: 100px; text-align: center;">{{items[index].price.cost || 0}}<span v-if="items[index].need_percent_price">, %</span><span v-else>, ₽</span>
                            </td>
                        </tr>


                        </tbody>
                    </table>
                </td>


<!--                <td class="text-center">
                    {{ item.updated_at || '-' }}
                </td>-->

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
                v-on:pagination_page="loadDoorVariants"
                v-if="paginate_object"
                :pagination="paginate_object"/>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="door-variant-editor-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content rounded-0">

                <div class="modal-body ">
                    <template v-if="selected_item">
                        <DoorVariantForm
                            v-if="!loading"
                            :item="selected_item"
                            v-on:callback="selectItem(null)"></DoorVariantForm>
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
                }
            ]
        }
    },
    computed: {
        ...mapGetters(['getDoorVariants', 'getDoorVariantsPaginateObject']),
    },
    mounted() {
        this.loadDoorVariants();

        this.editor_modal = new bootstrap.Modal(document.getElementById('door-variant-editor-modal'), {})
    },
    methods: {
        sortAndLoad(column) {
            this.sort.column = column
            this.sort.direction = this.sort.direction === "desc" ? "asc" : "desc"
            this.loadDoorVariants(this.current_page)
        },

        loadDoorVariants(page = 0) {
            this.current_page = page
            this.$store.dispatch("loadDoorVariants", {
                dataObject: {
                    search: this.search,
                    order: this.sort.column,
                    direction: this.sort.direction
                },
                page: this.current_page
            }).then(resp => {
                this.items = this.getDoorVariants
                this.paginate_object = this.getDoorVariantsPaginateObject

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
