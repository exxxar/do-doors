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
                <h6>Новые фотографии к материалу</h6>
            </div>
            <div class="col-md-3 mb-2 image-preview" v-for="(image, index) in uploaded_variants_image">
                <img :src="getPhoto(image).imageUrl"
                     class="uploaded-image-mini"
                     alt="">

                <div class="shadow justify-content-center align-items-center">
                    <a href="javascript:void(0)" @click="removePhoto('uploaded_variants_image',index)">Удалить</a>
                </div>
            </div>
            <div class="col-12" v-if="form.variants.length>0">
                <h6>Текущие фотографии к материалу</h6>
            </div>
            <div class="col-md-3 mb-2 image-preview" v-for="(image, index) in form.variants">
                <img :src="'/images/'+image"
                     class="uploaded-image-mini"
                     alt="">

                <div class="shadow justify-content-center align-items-center">
                    <a href="javascript:void(0)" @click="removeUploadedPhoto('variants',index)">Удалить</a>
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
</template>
<script>
export default {
    props: ["item"],
    data() {
        return {
            messages: [],
            uploaded_variants_image: [],
            loading: false,
            form: {
                id: null,
                title: null,
                price: null,
                variants: [],

            }
        }
    },
    computed: {
        needClearForm() {
            return this.form.id ||
                this.form.title ||
                this.form.price ||
                this.uploaded_variants_image.length > 0

        }
    },
    mounted() {
        if (this.item)
            this.$nextTick(() => {
                this.form = {
                    id: this.item.id || null,
                    title: this.item.title || null,
                    price: this.item.price || 0,
                    variants: this.item.variants || [],

                }
            })
    },
    methods: {
        alert(msg) {
            this.messages.push(msg)
        },
        resetForm() {
            this.uploaded_variants_image = []

            this.form.id = null
            this.form.title = null
            this.form.price = 0
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
                this[param].push(files[i])

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


            for (let i = 0; i < this.uploaded_variants_image.length; i++)
                data.append('uploaded_variants_image[]', this.uploaded_variants_image[i]);


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
