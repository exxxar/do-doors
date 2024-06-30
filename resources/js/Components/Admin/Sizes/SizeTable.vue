<script setup>
import Pagination from "@/Components/Pagination.vue";
import MaterialDropdown from "@/Components/Admin/Materials/MaterialDropdown.vue";
</script>
<template>

    <!--    <div class="row">
            <div class="col-12">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a
                            @click="tab=0"
                            v-bind:class="{'active':tab===0,'text-secondary':tab!==0}"
                            class="nav-link rounded-0 "
                            href="javascript:void(0)">Размеры</a>
                    </li>
                    <li class="nav-item">
                        <a
                            @click="tab=1"
                            v-bind:class="{'active':tab===1,'text-secondary':tab!==1}"
                            class="nav-link rounded-0"
                            href="javascript:void(0)">Петли</a>
                    </li>
                    <li class="nav-item">
                        <a
                            @click="tab=2"
                            v-bind:class="{'active':tab===2,'text-secondary':tab!==2}"
                            class="nav-link rounded-0"
                            href="javascript:void(0)">Цвета</a>
                    </li>
                    <li class="nav-item">
                        <a
                            @click="tab=3"
                            v-bind:class="{'active':tab===3,'text-secondary':tab!==3}"
                            class="nav-link rounded-0"
                            href="javascript:void(0)">Ширина</a>
                    </li>
                </ul>
            </div>
        </div>-->

    <form class="row">
        <div class="col-12">

            <div class="input-group mb-3">
                <div class="form-floating">
                    <input type="search"
                           v-model="search"
                           class="form-control" id="search-sizes">
                    <label

                        for="search-sizes">Поиск</label>
                </div>
                <button
                    @click="sortAndLoad('id')"
                    type="button" class="btn btn-outline-secondary rounded-0">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>


        </div>
    </form>
    <!-- Button trigger modal -->


    <div class="row">
        <div class="col-12">
            <h4>Выбор типа данных</h4>
            <div class="d-flex py-2">
                <button
                    v-bind:class="{'btn-dark text-white':sort.type === null}"
                    @click="sort.type = null"
                    class="btn btn-outline-secondary mr-2 rounded-0">Всё
                </button>
                <button
                    v-bind:class="{'btn-dark text-white':sort.type === 'sizes'}"
                    @click="sort.type = 'sizes'"
                    class="btn btn-outline-secondary mr-2 rounded-0">Размеры
                </button>
                <button
                    v-bind:class="{'btn-dark text-white':sort.type === 'loops'}"
                    @click="sort.type = 'loops'"
                    class="btn btn-outline-secondary mr-2 rounded-0">Петли
                </button>
                <button
                    v-bind:class="{'btn-dark text-white':sort.type === 'colors'}"
                    @click="sort.type = 'colors'"
                    class="btn btn-outline-secondary mr-2 rounded-0">Цвет
                </button>
                <button
                    v-bind:class="{'btn-dark text-white':sort.type === 'depth'}"
                    @click="sort.type = 'depth'"
                    class="btn btn-outline-secondary mr-2 rounded-0">Толщина
                </button>
            </div>

        </div>
    </div>
    <div class="d-flex scrollable-area">
        <table class="table table-responsive" v-if="items.length>0">
            <thead>
            <tr>
                <th scope="col" class="cursor-pointer" @click="sortAndLoad('id')">#
                    <span v-if="sort.direction === 'desc'&&sort.column === 'id'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'id'"><i
                        class="fa-solid fa-caret-up"></i></span>
                </th>
                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('width')">Ширина, см
                    <span v-if="sort.direction === 'desc'&&sort.column === 'width'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'width'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>
                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('height')">Высота, см
                    <span v-if="sort.direction === 'desc'&&sort.column === 'height'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'height'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>
                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('price')">Цена, руб
                    <span v-if="sort.direction === 'desc'&&sort.column === 'price'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'price'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>
                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('price_koef')">Ценовой
                    коэффициент
                    <span v-if="sort.direction === 'desc'&&sort.column === 'price_koef'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'price_koef'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>
                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('type')">Тип данных
                    <span v-if="sort.direction === 'desc'&&sort.column === 'type'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'type'"><i
                        class="fa-solid fa-caret-up"></i></span>
                </th>

                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('value')">Значение параметра
                    <span v-if="sort.direction === 'desc'&&sort.column === 'value'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'value'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>
                <th scope="col" class="text-center" @click="sortAndLoad('material_id')">Материал
                    <span v-if="sort.direction === 'desc'&&sort.column === 'material_id'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'material_id'"><i
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
                    {{ item.width || 0 }}
                </td>
                <td class="text-center" @click="selectItem(item)">
                    {{ item.height || 0 }}

                </td>
                <td class="text-center">

                    <table>
                        <thead>
                        <th>опт</th>
                        <th>дилер</th>
                        <th>розница</th>
                        <th>себестоимость</th>
                        </thead>
                        <tbody>
                        <tr>
                            <td style="min-width: 100px; text-align: center;">{{ items[index].price.wholesale || 0 }}
                            </td>
                            <td style="min-width: 100px; text-align: center;">{{ items[index].price.dealer || 0 }}</td>
                            <td style="min-width: 100px; text-align: center;">{{ items[index].price.retail || 0 }}</td>
                            <td style="min-width: 100px; text-align: center;">{{ items[index].price.cost || 0 }}</td>
                        </tr>


                        </tbody>
                    </table>
                </td>
                <td class="text-center">
                    <p v-if="!items[index].need_edit_koef" @click="items[index].need_edit_koef = true">
                        {{ items[index].price_koef || 0 }}</p>
                    <input
                        v-if="items[index].need_edit_koef"
                        type="number"
                        step="0.1"
                        min="0"
                        @blur="blurParams('price_koef', index)"
                        @change="saveParam('price_koef', index)"
                        v-model="items[index].price_koef"
                        class="form-control text-center"
                        id="floatingInput"
                        placeholder="name@example.com">

                </td>

                <td class="text-center">

                    <span v-if="item.type==='sizes'">Размеры</span>
                    <span v-if="item.type==='loops'">Петли</span>
                    <span v-if="item.type==='colors'">Цвета</span>
                    <span v-if="item.type==='depth'">Толщина</span>

                </td>
                <td class="text-center">
                    {{ item.loops_count || 0 }}

                </td>
                <td class="text-center">
                    <p v-if="item.material">
                        {{ item.material.title || '-' }} (#{{ item.material_id || '-' }})
                    </p>
                    <p v-else>Материал не выбран</p>
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
                                   @click="recountByKoef(item)"
                                   href="javascript:void(0)"><i class="fa-solid fa-bolt mr-2"></i>Пересчитать по
                                коэффициенту</a></li>

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


    <div class="alert alert-success my-3" role="alert" v-if="items.length===0">
        <h4 class="alert-heading">Размеры</h4>
        <p>К сожалению, раздел размеров пуст. Вы еще не добавили ни одного размера, который можно отобразить на этой
            странице.</p>
        <hr>
        <p class="mb-0">Воспользуйтесь формой выше и добавьте свой первый размер</p>
    </div>
    <div class="row mb-3" v-if="items.length>0">
        <div class="col-12">
            <Pagination
                v-on:pagination_page="loadSizes"
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
                direction: "desc",
                type: "sizes"
            },
            search: null,
            current_page: 0,
            paginate_object: null,
            items: []
        }
    },
    computed: {
        ...mapGetters(['getSizesPaginateObject', 'getSizes']),
    },
    watch: {
        'sort.type': {
            handler: function (newValue) {
                this.loadSizes();
            },
            deep: true
        }
    },
    mounted() {
        this.loadSizes();

        window.addEventListener("load-sizes", () => {
            this.loadSizes();

        })
    },
    methods: {

        saveFormattedSizes() {
            this.$store.dispatch("loadFormattedSizes").then(resp => {
                this.confirmModal.hide()
                this.loadSizes();
                this.$notify({
                    title: "DoDoors",
                    text: "Вы успешно обновили данные",
                });
            }).catch(() => {
                this.$notify({
                    title: "DoDoors",
                    text: "Ошибка обновления данных",
                    type: 'error'
                });
            })
        },
        sortAndLoad(column) {
            this.sort.column = column
            this.sort.direction = this.sort.direction === "desc" ? "asc" : "desc"
            this.loadSizes(this.current_page)
        },

        loadSizes(page = 0) {
            this.current_page = page
            this.$store.dispatch("loadSizes", {
                dataObject: {
                    search: this.search,
                    order: this.sort.column,
                    type: this.sort.type,
                    direction: this.sort.direction
                },
                page: this.current_page
            }).then(resp => {
                this.items = this.getSizes
                this.paginate_object = this.getSizesPaginateObject

            }).catch(() => {
                this.loading = false
            })
        },
        selectItem(item) {
            this.$emit("select", item)
        },
        duplicateItem(id) {
            this.$store.dispatch("duplicateSize", {
                sizeId: id
            }).then(() => {
                this.sortAndLoad("id")
            })
        },
        removeItem(id) {
            this.$store.dispatch("removeSize", {
                sizeId: id
            }).then(() => {
                this.sortAndLoad("id")
            })
        },

        blurParams(param, index) {


            this.items[index].need_edit_wholesale_price = false
            this.items[index].need_edit_dealer_price = false
            this.items[index].need_edit_retail_price = false
            this.items[index].need_edit_cost_price = false
            this.items[index].need_edit_koef = false
        },
        saveParam(param, index) {

            this.$store.dispatch("updateSizeParam", {
                dataObject: {
                    id: this.items[index].id,
                    key: param,
                    value: this.items[index][param],
                },
            }).then(resp => {
                //this.loadSizes(0)
                this.items[index].need_edit_wholesale_price = false
                this.items[index].need_edit_dealer_price = false
                this.items[index].need_edit_retail_price = false
                this.items[index].need_edit_cost_price = false
                this.items[index].need_edit_koef = false

                this.$notify({
                    title: "DoDoors",
                    text: "Параметры успешно обновлены",
                });
            }).catch(() => {
                // this.loading = false
            })
        }
    }
}
</script>
