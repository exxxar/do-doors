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

        <div class="form-floating mb-3">
            <input type="number"
                   v-model="form.price"
                   class="form-control" id="handle-price"
                   required>
            <label for="handle-title">Цена ручки</label>
        </div>

        <div class="input-group mb-3">
                <span class="input-group-text border-secondary"
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
                <div class="card w-100">
                    <img
                        style="min-height: 200px;"
                        :src="getPhoto(variant.image).imageUrl"
                        class="card-img-top uploaded-image-mini"
                        alt="">

                    <div class="card-body d-flex justify-center">
                        <a href="javascript:void(0)" class="text-danger"
                           @click="removePhoto('uploaded_variants_image',index)">Удалить фото</a>
                    </div>

                    <div class="card-body">


                        <div class="form-floating mb-3 ">
                            <input type="text" v-model="uploaded_variants_image[index].title"
                                   class="form-control border-gray-300 rounded-md" id="floatingInput" required>
                            <label for="floatingInput">Название</label>
                        </div>


                        <div class="form-floating">
                            <textarea class="form-control"
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
                        v-if="variant.image.indexOf('http')===-1"
                        :src="'/images/'+variant.image"
                        class="card-img-top uploaded-image-mini"
                        alt="">

                    <img
                        v-else
                        style="min-height: 200px;"
                        :src="variant.image"
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
                    class="btn btn-outline-success rounded-5">
                    <i class="fa-regular fa-floppy-disk mr-1" v-if="!loading"></i>
                    <span class="spinner-border spinner-border-sm  text-success"
                          role="status" v-else></span>
                    Сохранить ручку
                </button>
                <button
                    v-if="needClearForm&&!loading"
                    type="button"
                    @click="resetForm"
                    class="btn btn-outline-danger rounded-5 ml-2">
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
            uploaded_variants_image: [],
            loading: false,
            colorModal: null,
            form: {
                id: null,
                title: null,
                price: null,
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
                    price: this.item.price || 0,
                    color: this.item.color || null,
                    variants: this.item.variants || [],

                }
            })
    },
    methods: {
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
            this.form.price = 0
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


        }
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
