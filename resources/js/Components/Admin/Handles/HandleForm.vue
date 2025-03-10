<script setup>
import RalColorSelector from "@/Components/Support/RalColorSelector.vue";
</script>
<template>


    <form action="" v-on:submit.prevent="submit">
        <div class="form-floating mb-3">
            <input type="text"
                   v-model="form.title"
                   class="form-control" id="handle-title"
                   required>
            <label for="handle-title">Название ручки</label>
        </div>

        <div class="card rounded-0 mb-3 border-black">
            <div class="card-header bg-dark text-white rounded-0 ">
                <h6>Настройка цены</h6>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <input type="number"
                                   v-model="form.price.wholesale"
                                   class="form-control" id="price-wholesale"
                                   required>
                            <label for="price-wholesale">Опт</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <input type="number"
                                   v-model="form.price.retail"
                                   class="form-control" id="price-retail"
                                   required>
                            <label for="price-retail">Розница</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="number"
                                   v-model="form.price.dealer"
                                   class="form-control" id="price-dealer"
                                   required>
                            <label for="price-dealer">Дилер</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="number"
                                   v-model="form.price.cost"
                                   class="form-control" id="price-cost"
                                   required>
                            <label for="price-cost">Себестоимость</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="input-group mb-3">
                <span class="input-group-text border-secondary rounded-0"
                      v-if="isHex(form.color)"
                      v-bind:style="{'background-color':form.color}"
                      id="basic-addon1" style="width: 40px;">
                </span>
            <div class="form-floating">
                <input type="text"
                       @invalid="alert('Вы не выбрали цвет фурнитуры')"
                       v-model="form.color"
                       class="form-control" id="fittings_color" required>
                <label for="fittings_color"><i class="fa-solid fa-palette"></i> Цвет ручки</label>
            </div>

            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#" @click="form.color = null">Не выбрано</a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item"
                       @click="selectColor"
                       href="javascript:void(0)">Цвет RAL</a></li>
            </ul>


        </div>

        <div class="form-floating mb-3 border-gray-100 border">
            <input type="file" class="form-control"
                   accept="image/*"
                   id="door-handle"
                   ref="handleImageRef"
                   @change="onChangePhotos('uploaded_variants_image', $event)"
                   multiple>
            <label for="door-handle">Вариант ручки</label>
        </div>

        <div class="row">
            <div class="col-12" v-if="uploaded_variants_image.length>0">
                <h6 class="font-bold my-3">Новые фотографии к ручке</h6>
            </div>

            <div class="col-md-4 mb-2 image-preview d-flex align-items-start"
                 v-if="uploaded_variants_image.length>0"
                 v-for="(variant, index) in uploaded_variants_image">
                <div class="card w-100 rounded-0">
                    <img
                        style="min-height: 200px;"
                        v-lazy="getPhoto(variant.image).imageUrl"
                        class="card-img-top uploaded-image-mini"
                        alt="">

                    <div class="card-body d-flex justify-center">
                        <a href="javascript:void(0)" class="text-danger"
                           @click="removePhoto('uploaded_variants_image',index)">Удалить фото</a>
                    </div>

                    <div class="card-body">


                        <div class="form-floating mb-2 ">
                            <input type="text" v-model="uploaded_variants_image[index].title"
                                   class="form-control border-gray-300 rounded-0" id="floatingInput" required>
                            <label for="floatingInput">Название</label>
                        </div>


                        <div class="form-floating">
                            <textarea class="form-control rounded-0"
                                      v-model="uploaded_variants_image[index].description"
                                      placeholder="Leave a comment here" id="floatingTextarea" required></textarea>
                            <label for="floatingTextarea">Описание</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12" v-if="form.variants.length>0">
                <h6 class="font-bold my-3">Ранее загруженные фотографии к ручке</h6>
            </div>
            <div class="col-md-4 mb-2 image-preview d-flex align-items-start" v-for="(variant, index) in form.variants">

                <div class="card w-100">

                    <img

                        style="min-height: 200px;"
                        v-lazy="prepareImage(variant.image)"
                        class="card-img-top uploaded-image-mini"
                        alt="">
                    <div class="card-body d-flex justify-center">
                        <a href="javascript:void(0)" class="text-danger" @click="removeUploadedPhoto('variants',index)">Удалить</a>
                    </div>
                    <div class="card-body">


                        <div class="form-floating mb-3 ">
                            <input type="text" v-model="form.variants[index].title"
                                   class="form-control border-gray-300 rounded-md" id="floatingInput">
                            <label for="floatingInput">Название</label>
                        </div>


                        <div class="form-floating">
                            <textarea class="form-control"
                                      v-model="form.variants[index].description"
                                      placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                            <label for="floatingTextarea">Описание</label>
                        </div>
                    </div>
                </div>


            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div
                    v-if="messages.length>0"
                    v-for="(message, index) in messages"
                    class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Внимание!</strong> {{ message || 'Ошибка' }}
                    <button type="button" class="btn-close"
                            @click="removeMessage(index)"></button>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                <button
                    :disabled="!needClearForm"
                    class="btn btn-dark rounded-0">
                    <i class="fa-regular fa-floppy-disk mr-1" v-if="!loading"></i>
                    <span class="spinner-border spinner-border-sm  text-success"
                          role="status" v-else></span>
                    Сохранить ручку
                </button>
                <button
                    v-if="needClearForm&&!loading"
                    type="button"
                    @click="resetForm"
                    class="btn btn-outline-secondary rounded-0 ml-2">
                    <i class="fa-solid fa-xmark mr-1"></i>
                    Очистить форму
                </button>

            </div>
        </div>
    </form>




    <!-- Modal -->
    <div class="modal fade" :id="'choose-color-handle'" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Выбор цвета RAL</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <RalColorSelector v-on:select="callbackSelectColor"></RalColorSelector>

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
            messages: [],
            need_import_from_google:false,
            uploaded_variants_image: [],
            loading: false,
            colorModal: null,


            form: {
                id: null,
                title: null,
                price: {
                    wholesale: 0,
                    dealer: 0,
                    retail: 0,
                    cost: 0,
                },
                color: null,
                variants: [],

            }
        }
    },
    computed: {
        needClearForm() {
            return this.form.id ||
                this.form.title ||
                this.form.price ||
                this.form.color ||
                this.uploaded_variants_image.length > 0

        }
    },
    mounted() {
        this.colorModal = new bootstrap.Modal(document.getElementById('choose-color-handle'), {})

        if (this.item)
            this.$nextTick(() => {
                this.form = {
                    id: this.item.id || null,
                    title: this.item.title || null,
                    price: this.item.price || {
                        wholesale: 0,
                        dealer: 0,
                        retail: 0,
                        cost: 0,
                    },
                    color: this.item.color || null,
                    variants: this.item.variants || [],

                }
            })
    },
    methods: {

        prepareImage(image) {
            if (typeof image !== "string" || !image.trim()) return "/images/default.png"; // Защита от пустых и некорректных данных
            return image.startsWith("http://") || image.startsWith("https://") ? image : `/images/${image}`;
        },
        callbackSelectColor(item) {
            this.form.color = item.color.hex

            this.colorModal.hide()
        },

        selectColor() {
            this.colorModal.show()
        },
        isHex(num) {
            return /^#[0-9A-F]{6}$/i.test(num)
        },
        alert(msg) {
            this.messages.push(msg)
        },
        resetForm() {
            this.uploaded_variants_image = []

            this.form.id = null
            this.form.title = null
            this.form.price =   {
                wholesale: 0,
                dealer: 0,
                retail: 0,
                cost: 0,
            }
            this.form.color = null
            this.form.variants = []

            this.$refs.handleImageRef.value = null

            this.$emit("callback")

        },
        removeUploadedPhoto(param, index) {
            this.form[param].splice(index, 1)
        },
        removePhoto(param, index) {
            this[param].splice(index, 1)
        },
        getPhoto(imgObject) {
            return {imageUrl: URL.createObjectURL(imgObject)}
        },
        onChangePhotos(param, e) {
            const files = e.target.files
            for (let i = 0; i < files.length; i++)
                this[param].push({
                    image: files[i],
                    title: null,
                    description: null,
                })

        },
        removeMessage(index) {
            this.messages.splice(index, 1)
        },
        submit() {
            let data = new FormData();
            Object.keys(this.form)
                .forEach(key => {
                    const item = this.form[key] || ''
                    if (typeof item === 'object')
                        data.append(key, JSON.stringify(item))
                    else
                        data.append(key, item)
                });


            if (this.uploaded_variants_image.length > 0) {
                for (let i = 0; i < this.uploaded_variants_image.length; i++) {
                    data.append('uploaded_variants_image[]', this.uploaded_variants_image[i].image);

                    this.uploaded_variants_image[i].image_name = this.uploaded_variants_image[i].image.name || null
                }


                data.append('uploaded_image_info', JSON.stringify(this.uploaded_variants_image));
            }


            this.$store.dispatch("storeHandle", {
                handleForm: data
            }).then((response) => {
                this.$emit("callback")
                this.resetForm()
            }).catch(error => {

            })


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
<style lang="scss">
.uploaded-image-mini {
    width: 100%;
    object-fit: contain;
    max-height: 200px;
}

.image-preview {
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;


    & > .shadow {
        display: none;
        position: absolute;
        z-index: 1;
        background-color: rgba(0, 0, 0, 0.5);
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;

        a {
            color: white;
        }
    }

    &:hover {
        .shadow {
            display: flex;
        }
    }
}
</style>
