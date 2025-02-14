<template>
    <div class="row">
        <div class="col-12 d-flex">

            <div class="dropdown mb-2">
                <button
                    class="btn btn-outline-secondary dropdown-toggle w-100 rounded-0 p-3"
                    type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fa-solid fa-bars mr-2"></i>Управление разделом
                </button>
                <ul class="dropdown-menu rounded-0">
                    <li><a class="dropdown-item" href="/sizes/export-prices">Скачать шаблон таблицы</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0)" @click="openImportFormModal">Загрузить данные</a></li>

                    <li><a class="dropdown-item" href="javascript:void(0)" @click="openConfirmModal">Обновить JSON</a>
                    </li>
                    <!--                    <li><a class="dropdown-item" href="javascript:void(0)" @click="recountModalShow">Пересчет
                                            показателей</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" @click="generateModalShow"> Генерация
                                            размеров</a></li>-->
                </ul>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="import-prices-form" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Форма загрузки таблицы</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row mb-3">
                        <div class="col">
                            <div
                                style="min-height: 80px;"
                                @click="need_import_from_google = true"
                                v-bind:class="{'bg-dark text-white':need_import_from_google}"
                                class="card rounded-0">
                                <div class="card-body  d-flex justify-content-center align-items-center text-center cursor-pointer">
                                    <p style="line-height: 100%;"
                                       class=" d-flex justify-content-center align-items-center text-center mb-0">
                                        <i v-if="need_import_from_google" class="fa-solid fa-check mr-2"></i>
                                        Загрузить из Google-таблицы</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div
                                style="min-height: 80px;"
                                @click="need_import_from_google = false"
                                v-bind:class="{'bg-dark text-white':!need_import_from_google}"
                                class="card rounded-0">
                                <div class="card-body d-flex justify-content-center align-items-center text-center cursor-pointer">
                                    <p style="line-height: 100%;"
                                       class=" d-flex justify-content-center align-items-center text-center mb-0">
                                        <i v-if="!need_import_from_google" class="fa-solid fa-check mr-2"></i>
                                        Загрузить из Excel-файла</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form
                        v-if="!need_import_from_google"
                        v-on:submit.prevent="importSubmit">



                        <div class="row mb-3">
                            <div class="col">
                                <div
                                    style="min-height: 80px;"
                                    @click="importForm.need_rewrite = true"
                                    v-bind:class="{'bg-dark text-white':importForm.need_rewrite}"
                                    class="card rounded-0">
                                    <div class="card-body cursor-pointer d-flex justify-content-center align-items-center">

                                        <p style="line-height: 100%;" class=" d-flex justify-content-center align-items-center text-center mb-0">
                                            <i v-if="importForm.need_rewrite" class="fa-solid fa-check mr-2"></i>Перезаписать старые значения</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div
                                    style="min-height: 80px;"
                                    @click="importForm.need_rewrite = false"
                                    v-bind:class="{'bg-dark text-white':!importForm.need_rewrite}"
                                    class="card rounded-0">
                                    <div class="card-body d-flex justify-content-center align-items-center text-center cursor-pointer">

                                        <p style="line-height: 100%;"
                                           class=" d-flex justify-content-center align-items-center text-center mb-0">
                                            <i v-if="!importForm.need_rewrite" class="fa-solid fa-check mr-2"></i>
                                        Добавить новые значения</p>
                                    </div>
                                </div>
                            </div>
                        </div>

<!--                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   v-model="importForm.need_rewrite"
                                   type="checkbox" role="switch" id="need_rewrite">
                            <label class="form-check-label" for="need_rewrite">
                                <span v-if="importForm.need_rewrite">Перезаписать старые значения</span>
                                <span v-else>Добавить новые значения</span>

                            </label>
                        </div>-->

                        <div class="row mb-3">
                            <div class="col">
                                <div
                                    style="min-height: 80px;"
                                    @click="importForm.use_price_koef = true"
                                    v-bind:class="{'bg-dark text-white':importForm.use_price_koef}"
                                    class="card rounded-0">
                                    <div class="card-body  d-flex justify-content-center align-items-center text-center cursor-pointer">

                                        <p style="line-height: 100%;"
                                           class=" d-flex justify-content-center align-items-center text-center mb-0">
                                            <i v-if="importForm.use_price_koef" class="fa-solid fa-check mr-2"></i>
                                            Пересчитать по коэффициентам</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div
                                    style="min-height: 80px;"
                                    @click="importForm.use_price_koef = false"
                                    v-bind:class="{'bg-dark text-white':!importForm.use_price_koef}"
                                    class="card rounded-0">
                                    <div class="card-body d-flex justify-content-center align-items-center text-center cursor-pointer">

                                        <p style="line-height: 100%;"
                                           class=" d-flex justify-content-center align-items-center text-center mb-0">
                                            <i v-if="!importForm.use_price_koef" class="fa-solid fa-check mr-2"></i>
                                            Записать как есть</p>
                                    </div>
                                </div>
                            </div>
                        </div>


<!--                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   v-model="importForm.use_price_koef"
                                   type="checkbox" role="switch" id="use_price_koef">
                            <label class="form-check-label" for="use_price_koef">
                                <span
                                    v-if="importForm.use_price_koef">Использовать ценовые коэффициенты для расчета</span>
                                <span v-else>Записать как есть</span>

                            </label>
                        </div>-->

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
                                class="btn btn-dark rounded-0 w-100 p-3">Загрузить
                            <span v-if="timer!=null">{{ timer }} сек</span>
                        </button>
                    </form>
                    <form
                        v-else
                        v-on:submit.prevent="importFromGoogleSubmit">

                        <div class="row mb-3">
                            <div class="col">
                                <div
                                    style="min-height: 80px;"
                                    @click="importGoogleForm.need_rewrite = true"
                                    v-bind:class="{'bg-dark text-white':importGoogleForm.need_rewrite}"
                                    class="card rounded-0">
                                    <div class="card-body  d-flex justify-content-center align-items-center text-center cursor-pointer">
                                        <p style="line-height: 100%;"
                                           class=" d-flex justify-content-center align-items-center text-center mb-0">
                                            <i v-if="importGoogleForm.need_rewrite" class="fa-solid fa-check mr-2"></i>
                                            Перезаписать старые значения</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div
                                    style="min-height: 80px;"
                                    @click="importGoogleForm.need_rewrite = false"
                                    v-bind:class="{'bg-dark text-white':!importGoogleForm.need_rewrite}"
                                    class="card rounded-0">
                                    <div class="card-body d-flex justify-content-center align-items-center text-center cursor-pointer">

                                        <p style="line-height: 100%;"
                                           class=" d-flex justify-content-center align-items-center text-center mb-0">
                                            <i v-if="!importGoogleForm.need_rewrite" class="fa-solid fa-check mr-2"></i>
                                            Добавить новые значения</p>
                                    </div>
                                </div>
                            </div>
                        </div>


<!--                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   v-model="importGoogleForm.need_rewrite"
                                   type="checkbox" role="switch" id="need_rewrite_google">
                            <label class="form-check-label" for="need_rewrite_google">
                                <span v-if="importGoogleForm.need_rewrite">Перезаписать старые значения</span>
                                <span v-else>Добавить новые значения</span>

                            </label>
                        </div>-->

                        <div class="row mb-3">
                            <div class="col">
                                <div
                                    style="min-height: 80px;"
                                    @click="importGoogleForm.use_price_koef = true"
                                    v-bind:class="{'bg-dark text-white':importGoogleForm.use_price_koef}"
                                    class="card rounded-0">
                                    <div class="card-body  d-flex justify-content-center align-items-center text-center cursor-pointer">
                                        <p style="line-height: 100%;"
                                           class=" d-flex justify-content-center align-items-center text-center mb-0">
                                            <i v-if="importGoogleForm.use_price_koef" class="fa-solid fa-check mr-2"></i>
                                            Пересчитать по коэффициентам</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div
                                    style="min-height: 80px;"
                                    @click="importGoogleForm.use_price_koef = false"
                                    v-bind:class="{'bg-dark text-white':!importGoogleForm.use_price_koef}"
                                    class="card rounded-0">
                                    <div class="card-body d-flex justify-content-center align-items-center text-center cursor-pointer">

                                        <p style="line-height: 100%;"
                                           class=" d-flex justify-content-center align-items-center text-center mb-0">
                                            <i v-if="!importGoogleForm.use_price_koef" class="fa-solid fa-check mr-2"></i>
                                            Записать как есть</p>
                                    </div>
                                </div>
                            </div>
                        </div>

<!--                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   v-model="importGoogleForm.use_price_koef"
                                   type="checkbox" role="switch" id="importGoogleForm_use_price_koef">
                            <label class="form-check-label" for="importGoogleForm_use_price_koef">
                                <span v-if="importGoogleForm.use_price_koef">Использовать ценовые коэффициенты для расчета</span>
                                <span v-else>Записать как есть</span>

                            </label>
                        </div>-->

                        <div class="form-floating my-3 border-gray-100 border">
                            <input type="text" class="form-control"
                                   v-model="importGoogleForm.sheet_id"
                                   id="sheet-id" placeholder="name@example.com">
                            <label for="sheet-id">Идентификатор таблицы</label>
                        </div>


                        <button type="submit"
                                :disabled="timer!=null"
                                class="btn btn-dark rounded-0 w-100 p-3">Загрузить
                            <span v-if="timer!=null">{{ timer }} сек</span>
                        </button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-0"
                            data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirm-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content rounded-0">

                <div class="modal-body">
                    <p>Вы хотите обновить JSON-файл с размерами?</p>
                    <div class="row">
                        <div class="col-6">
                            <button class="btn btn-dark rounded-0 w-100" type="button" @click="saveFormattedSizes">Да,
                                продолжить
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-secondary rounded-0 w-100" @click="confirmModal.hide()">Нет,
                                отменить
                            </button>
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
            timer: null,
            affected: null,
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
            need_import_from_google: false,
            importGoogleForm: {
                sheet_id: null,
                use_price_koef: false,
                need_rewrite: true,
            },
            importForm: {
                need_rewrite: true,
                use_price_koef: false,
                files: [],
            },
            recountForm: {
                selected_material: null,
                need_recount_by_width: false,
                need_recount_by_height: false,
                base_width: null,
                base_height: null,
                recount_price: null,
            },
            confirmModal: null,
            importPricesModal: null,

        }
    },
    mounted() {
        this.confirmModal = new bootstrap.Modal(document.getElementById('confirm-modal'), {})
        this.importPricesModal = new bootstrap.Modal(document.getElementById('import-prices-form'), {})
        this.importGoogleForm.sheet_id = localStorage.getItem("google_excel_export_sheet_id") || null
    },
    methods: {
        openConfirmModal() {
            this.confirmModal.show()
        },
        onChangeFile(e) {
            const files = e.target.files
            for (let i = 0; i < files.length; i++)
                this.importForm.files.push(files[i])

        },
        saveFormattedSizes() {
            this.$store.dispatch("updatedFormattedSizes").then(resp => {
                this.confirmModal.hide()
                window.dispatchEvent(new CustomEvent("load-sizes", {
                    detail: null
                }));
                this.$notify({
                    title: "DoDoors",
                    text: "Вы успешно обновили данные",
                });
                window.location.reload()
            }).catch(() => {
                this.$notify({
                    title: "DoDoors",
                    text: "Ошибка обновления данных",
                    type: 'error'
                });
                window.location.reload()
            })
        },
        openImportFormModal() {
            this.importPricesModal.show()
        },
        importFromGoogleSubmit() {
            let data = new FormData();


            localStorage.setItem("google_excel_export_sheet_id", this.importGoogleForm.sheet_id)

            this.timer = 0
            let tmpTimer = setInterval(() => {
                this.timer++
            }, 1000)

            Object.keys(this.importGoogleForm)
                .forEach(key => {
                    const item = this.importGoogleForm[key] || ''
                    if (typeof item === 'object')
                        data.append(key, JSON.stringify(item))
                    else
                        data.append(key, item)
                });

            this.$store.dispatch("importSizesFromGoogle", {
                importForm: data
            }).then((response) => {

                window.open(response.url, '_blank').focus();

                window.dispatchEvent(new CustomEvent("load-sizes", {
                    detail: null
                }));

                this.importPricesModal.hide()
                this.$notify({
                    title: "DoDoors",
                    text: "Вы успешно загрузили данные",
                });

                clearInterval(tmpTimer)
                this.timer = null
                this.confirmModal.show()
            }).catch(() => {
                clearInterval(tmpTimer)
                this.timer = null
                this.$notify({
                    title: "DoDoors",
                    text: "Ошибка загрузки данных",
                    type: "error"
                });
            })
        },
        importSubmit() {
            let data = new FormData();


            this.timer = 0
            let tmpTimer = setInterval(() => {
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

            if (this.importForm.files.length > 0) {

                data.delete("files")

                for (let i = 0; i < this.importForm.files.length; i++) {
                    data.append('files[]', this.importForm.files[i]);
                }
            }

            this.$store.dispatch("importSizes", {
                importForm: data
            }).then((response) => {


                window.dispatchEvent(new CustomEvent("load-sizes", {
                    detail: null
                }));

                this.importPricesModal.hide()
                this.$notify({
                    title: "DoDoors",
                    text: "Вы успешно загрузили данные",
                });

                clearInterval(tmpTimer)
                this.timer = null
                this.confirmModal.show()
            }).catch(() => {
                clearInterval(tmpTimer)
                this.timer = null
                this.$notify({
                    title: "DoDoors",
                    text: "Ошибка загрузки данных",
                    type: "error"
                });
            })
        },

    }
}
</script>
