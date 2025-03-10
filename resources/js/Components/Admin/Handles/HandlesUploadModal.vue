<template>
    <button
        class="my-3 p-3 border-gray-100 border btn rounded-0"
        type="button"
        @click="openImportFormModal">
        <i class="fa-solid fa-file-import"></i> Загрузить данные из таблицы
    </button>

    <!-- Modal -->
    <div class="modal fade" id="import-handles-form" tabindex="-1" aria-labelledby="exampleModalLabel"
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

</template>
<script>
export default {
    props: ["item"],
    data() {
        return {

            need_import_from_google:false,
            uploaded_variants_image: [],

            timer:null,
            importHandlesModal: null,
            importGoogleForm: {
                sheet_id: null,
                part:"handles",
                need_rewrite: true,
            },
            importForm: {
                files: [],
                need_rewrite: true,
            },

        }
    },

    mounted() {

        this.importHandlesModal = new bootstrap.Modal(document.getElementById('import-handles-form'), {})

        this.importGoogleForm.sheet_id = localStorage.getItem("google_excel_handles_export_sheet_id") || null

    },
    methods: {
        onChangeFile(e) {
            const files = e.target.files
            for (let i = 0; i < files.length; i++)
                this.importForm.files.push(files[i])

        },
        openImportFormModal() {
            this.importHandlesModal.show()
        },
        importFromGoogleSubmit() {
            let data = new FormData();


            localStorage.setItem("google_excel_handles_export_sheet_id", this.importGoogleForm.sheet_id)

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

            this.$store.dispatch("importHandlesFromGoogle", {
                importForm: data
            }).then((response) => {

                window.open(response.url, '_blank').focus();

                window.dispatchEvent(new CustomEvent("load-handles", {
                    detail: null
                }));

                this.importHandlesModal.hide()
                this.$notify({
                    title: "DoDoors",
                    text: "Вы успешно загрузили данные",
                });

                clearInterval(tmpTimer)
                this.timer = null
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

            this.$store.dispatch("importHandlesFromExcel", {
                importForm: data
            }).then((response) => {


                window.dispatchEvent(new CustomEvent("load-handles", {
                    detail: null
                }));

                this.importHandlesModal.hide()
                this.$notify({
                    title: "DoDoors",
                    text: "Вы успешно загрузили данные",
                });

                clearInterval(tmpTimer)
                this.timer = null

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
