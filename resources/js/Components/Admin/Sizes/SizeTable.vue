<script setup>
import Pagination from "@/Components/Pagination.vue";
import MaterialDropdown from "@/Components/Admin/Materials/MaterialDropdown.vue";
</script>
<template>
    <form class="row">
        <div class="col-12">

            <div class="input-group mb-3">
                <div class="form-floating">
                    <input type="search"
                           v-model="search"
                           class="form-control" id="search-sizes">
                    <label
                        @click="sortAndLoad('id')"
                        for="search-sizes">Поиск по размерам и материалам</label>
                </div>
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>


        </div>
    </form>
    <!-- Button trigger modal -->

    <div class="row">
        <div class="col-12 d-flex">

            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                    <i class="fa-solid fa-bars mr-2"></i>Управление разделом
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="/sizes/export-prices">Скачать шаблон таблицы</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0)" @click="openImportFormModal">Загрузить данные из Excel</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0)" @click="openConfirmModal">Обновить JSON</a>
                    </li>
                    <li><a class="dropdown-item" href="javascript:void(0)" @click="recountModalShow">Пересчет
                        показателей</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0)" @click="generateModalShow"> Генерация
                        размеров</a></li>
                </ul>
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
                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('price_koef')">Ценовой коэффициент
                    <span v-if="sort.direction === 'desc'&&sort.column === 'price_koef'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'price_koef'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>
                <th scope="col" class="text-center cursor-pointer" @click="sortAndLoad('loops_count')">Число петель
                    <span v-if="sort.direction === 'desc'&&sort.column === 'loops_count'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'loops_count'"><i
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
                            <td style="min-width: 100px; text-align: center;">{{items[index].price.wholesale|| 0}}</td>
                            <td style="min-width: 100px; text-align: center;" >{{items[index].price.dealer|| 0}}</td>
                            <td style="min-width: 100px; text-align: center;">{{items[index].price.retail|| 0}}</td>
                            <td style="min-width: 100px; text-align: center;">{{items[index].price.cost || 0}}</td>
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

    <!-- Modal -->
    <div class="modal fade" id="import-prices-form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Форма загрузки таблицы</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form v-on:submit.prevent="importSubmit">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   v-model="importForm.need_rewrite"
                                   type="checkbox" role="switch" id="need_rewrite">
                            <label class="form-check-label" for="need_rewrite">
                                <span v-if="importForm.need_rewrite">Перезаписать старые значения</span>
                                <span v-else>Добавить новые значения</span>

                            </label>
                        </div>

                        <div class="form-floating my-3 border-gray-100 border">
                            <input type="file" class="form-control"
                                   accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                   id="excel-file-for-import"
                                   ref="importPriceFromExcel"
                                   @change="onChangeFile($event)">
                            <label for="excel-file-for-import">Файл-эксель</label>
                        </div>

                        <button type="submit"
                                :disabled="timer!=null"
                                class="btn btn-outline-primary w-100 p-3">Загрузить
                            <span v-if="timer!=null">{{timer}} сек</span>
                        </button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="recount-prices" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Форма пересчета показателей</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form v-on:submit.prevent="submitRecountForm">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   v-model="recountForm.need_recount_by_width"
                                   type="checkbox" role="switch" id="recount-by-width">
                            <label class="form-check-label" for="recount-by-width">
                                Пересчитать по ширине
                            </label>
                        </div>

                        <div class="form-floating mb-3" v-if="recountForm.need_recount_by_width">
                            <input type="number"
                                   v-model="recountForm.base_width"
                                   class="form-control" id="base-width" required>
                            <label for="base-width">Базовая ширина</label>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   v-model="recountForm.need_recount_by_height"
                                   type="checkbox" role="switch" id="recount-by-height">
                            <label class="form-check-label" for="recount-by-height">
                                Пересчитать по высоте
                            </label>
                        </div>

                        <div class="form-floating mb-3" v-if="recountForm.need_recount_by_height">
                            <input type="number"
                                   v-model="recountForm.base_height"
                                   class="form-control" id="base-height" required>
                            <label for="base-height">Базовая высота</label>
                        </div>

                        <MaterialDropdown v-on:select="selectMaterialForRecount" class="mb-3">
                            <template v-slot:default>
                                <span v-if="recountForm.selected_material==null">Выбор материала</span>
                                <span v-else>{{ recountForm.selected_material.title || '-' }}</span>
                            </template>
                        </MaterialDropdown>

                        <div class="form-floating mb-3">
                            <input type="number"
                                   v-model="recountForm.recount_price"
                                   class="form-control" id="base-price" required>
                            <label for="base-price">Цена для пересчета</label>
                        </div>

                        <div class="alert alert-success mb-3" v-if="affected" role="alert">
                            Выполнен перерасчет. Затронуто {{ affected }} строк.
                        </div>

                        <button type="submit"
                                :disabled="recountForm.selected_material==null"
                                class="btn btn-outline-primary w-100 p-3">Выполнить пересчет
                        </button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="generate-sizes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Форма генерации размерности</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form v-on:submit.prevent="submitGenerateForm">


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number"
                                           v-model="generateForm.base_width"
                                           class="form-control" id="generate-base-width" required>
                                    <label for="generate-base-width">Базовая ширина</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number"
                                           v-model="generateForm.width_step"
                                           class="form-control" id="generate-step-width" required>
                                    <label for="generate-step-width">Шаг генерации ширины</label>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number"
                                           v-model="generateForm.base_height"
                                           class="form-control" id="generate-base-width" required>
                                    <label for="generate-base-width">Базовая высота</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number"
                                           v-model="generateForm.height_step"
                                           class="form-control" id="generate-step-width" required>
                                    <label for="generate-step-width">Шаг генерации высоты</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number"
                                           v-model="generateForm.base_koef"
                                           class="form-control" id="generate-base-width" required>
                                    <label for="generate-base-width">Базовый коэффициент</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number"
                                           step="0.1"
                                           v-model="generateForm.koef_step"
                                           class="form-control" id="generate-step-width" required>
                                    <label for="generate-step-width">Шаг генерации коэффициента</label>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number"
                                           v-model="generateForm.base_loops"
                                           class="form-control" id="generate-base-loops" required>
                                    <label for="generate-base-loops">Базовое число петель</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number"
                                           step="0.1"
                                           v-model="generateForm.loops_step"
                                           class="form-control" id="generate-step-width" required>
                                    <label for="generate-step-width">Шаг генерации петель</label>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number"
                                           v-model="generateForm.base_price"
                                           class="form-control" id="generate-base-price" required>
                                    <label for="generate-base-price">Базовая цена</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number"
                                           step="0.1"
                                           v-model="generateForm.price_step"
                                           class="form-control" id="generate-step-width" required>
                                    <label for="generate-step-width">Шаг генерации цены</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="number"
                                   v-model="generateForm.steps"
                                   class="form-control" id="generate-step-width" required>
                            <label for="generate-step-width">Число шагов генерации</label>
                        </div>

                        <MaterialDropdown v-on:select="selectMaterialForGeneration" class="mb-3">
                            <template v-slot:default>
                                <span v-if="generateForm.selected_material==null">Выбор материала</span>
                                <span v-else>{{ generateForm.selected_material.title || '-' }}</span>
                            </template>
                        </MaterialDropdown>

                        <div class="alert alert-success mb-3" v-if="affected" role="alert">
                            Выполнен перерасчет. Затронуто {{ affected }} строк.
                        </div>

                        <button type="submit"
                                :disabled="generateForm.selected_material==null"
                                class="btn btn-outline-primary w-100 p-3">Выполнить генерацию
                        </button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirm-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">
                    <p>Вы хотите обновить JSON-файл с размерами?</p>
                   <div class="row">
                       <div class="col-6">
                           <button class="btn btn-outline-success w-100" type="button" @click="saveFormattedSizes">Да, продолжить</button>
                       </div>
                       <div class="col-6">
                           <button class="btn btn-outline-danger w-100" @click="confirmModal.hide()">Нет, отменить</button>
                       </div>
                   </div>
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
            timer:null,
            affected: null,
            sort: {
                column: null,
                direction: "desc"
            },
            search: null,
            generateForm: {
                base_width: 0,
                base_height: 0,
                base_koef: 0,
                base_loops: 0,
                base_price: 0,
                width_step: 0,
                height_step: 0,
                koef_step: 0,
                loops_step: 0,
                price_step: 0,
                selected_material: null,
                steps: 0
            },
            importForm:{
                need_rewrite: false,
                files:[],
            },
            recountForm: {
                selected_material: null,
                need_recount_by_width: false,
                need_recount_by_height: false,
                base_width: null,
                base_height: null,
                recount_price: null,
            },
            recountModal: null,
            confirmModal: null,
            importPricesModal: null,
            generateModal: null,
            current_page: 0,
            paginate_object: null,
            items: [
            ]
        }
    },
    computed: {
        ...mapGetters(['getSizesPaginateObject', 'getSizes']),
    },
    mounted() {
        this.loadSizes();

        this.confirmModal = new bootstrap.Modal(document.getElementById('confirm-modal'), {})
        this.recountModal = new bootstrap.Modal(document.getElementById('recount-prices'), {})
        this.importPricesModal = new bootstrap.Modal(document.getElementById('import-prices-form'), {})
        this.generateModal = new bootstrap.Modal(document.getElementById('generate-sizes'), {})
    },
    methods: {
        openConfirmModal(){
            this.confirmModal.show()
        },
        onChangeFile( e) {
            const files = e.target.files
            for (let i = 0; i < files.length; i++)
               this.importForm.files.push(files[i])

        },
        saveFormattedSizes() {
            this.$store.dispatch("loadFormattedSizes").then(resp => {
                this.confirmModal.hide()
                this.$notify({
                    title: "DoDoors",
                    text: "Вы успешно обновили данные",
                });
            }).catch(() => {
                this.$notify({
                    title: "DoDoors",
                    text: "Ошибка обновления данных",
                    type:'error'
                });
            })
        },
        openImportFormModal(){
            this.importPricesModal.show()
        },
        generateModalShow() {
            this.generateModal.show()
        },
        recountModalShow() {

            this.affected = null
            this.recountForm.recount_price = 0
            this.recountForm.need_recount_by_height = false
            this.recountForm.need_recount_by_width = false
            this.recountForm.base_height = 0
            this.recountForm.base_width = 0
            this.recountForm.selected_material = null

            this.recountModal.show()

        },
        recountByKoef(item) {
            this.affected = null

            this.recountForm.recount_price = item.price
            this.recountForm.need_recount_by_height = true
            this.recountForm.need_recount_by_width = true
            this.recountForm.base_height = item.height
            this.recountForm.base_width = item.width
            this.recountForm.selected_material = item.material

            this.recountModal.show()
        },
        importSubmit(){
            let data = new FormData();


            this.timer = 0
            let tmpTimer = setInterval(()=>{
                this.timer++
            }, 1000)

            Object.keys(this.importForm)
                .forEach(key => {
                    const item = this.importForm[key] || ''
                    if (typeof item === 'object')
                        data.append(key, JSON.stringify(item))
                    else
                        data.append(key, item)
                });

            if (this.importForm.files.length>0) {

                data.delete("files")

                for (let i = 0; i < this.importForm.files.length; i++) {
                    data.append('files[]', this.importForm.files[i]);
                }
            }

            this.$store.dispatch("importSizes", {
                importForm: data
            }).then((response) => {
                this.loadSizes()
                this.importPricesModal.hide()
                this.$notify({
                    title: "DoDoors",
                    text: "Вы успешно загрузили данные",
                });

                clearInterval(tmpTimer)
                this.timer = null
                this.confirmModal.show()
            }).catch(()=>{
                clearInterval(tmpTimer)
                this.timer = null
                this.$notify({
                    title: "DoDoors",
                    text: "Ошибка загрузки данных",
                    type: "error"
                });
            })
        },
        submitRecountForm() {
            this.affected = null

            let data = new FormData();

            data.append("material_id", this.recountForm.selected_material.id)

            Object.keys(this.recountForm)
                .forEach(key => {
                    const item = this.recountForm[key] || ''
                    if (typeof item === 'object')
                        data.append(key, JSON.stringify(item))
                    else
                        data.append(key, item)
                });

            this.$store.dispatch("recountPrice", {
                recountForm: data
            }).then((response) => {
                this.affected = response.affected || 0
                this.loadSizes()

            })
        },
        submitGenerateForm() {
            let data = new FormData();

            data.append("material_id", this.generateForm.selected_material.id)

            Object.keys(this.generateForm)
                .forEach(key => {
                    const item = this.generateForm[key] || ''
                    if (typeof item === 'object')
                        data.append(key, JSON.stringify(item))
                    else
                        data.append(key, item)
                });

            this.$store.dispatch("generateSizes", {
                generateForm: data
            }).then((response) => {
                this.loadSizes()
                this.generateModal.hide();
            })
        },
        selectMaterialForRecount(item) {
            this.recountForm.selected_material = item
        },
        selectMaterialForGeneration(item) {
            this.generateForm.selected_material = item
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
