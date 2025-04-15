<template>

    <form action="" v-on:submit.prevent="submit">

        <div class="row">
            <div class="col-md-6 col-12">
                <div class="form-floating mb-3">
                    <input type="text"
                           v-model="form.title"
                           class="form-control" id="material-title"
                           placeholder="name@example.com" required>
                    <label for="material-title">Название материала</label>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-floating mb-3">
                    <input type="text"
                           v-model="form.order_position"
                           class="form-control" id="material-order-position"
                           placeholder="name@example.com" required>
                    <label for="material-order-position">Позиция материала в выдаче</label>
                </div>
            </div>
        </div>


        <div class="form-check form-switch mb-3">
            <input class="form-check-input"
                   v-model="form.is_base"
                   type="checkbox" role="switch" id="is-base">
            <label class="form-check-label" for="is-base">
                Является базой
            </label>
        </div>

        <div class="form-check form-switch mb-3">
            <input class="form-check-input"
                   v-model="form.need_generate_sizes"
                   type="checkbox" role="switch" id="recount-by-width">
            <label class="form-check-label" for="recount-by-width">
                Автоматически создать заглушки размеров
            </label>
        </div>

        <div class="form-check form-switch mb-3">
            <input class="form-check-input"
                   v-model="form.config.is_custom_color"
                   type="checkbox" role="switch" id="is-custom-color">
            <label class="form-check-label" for="is-custom-color">
                Ручной ввод цвета
            </label>
        </div>

        <div class="form-floating mb-3 border-gray-100 border">
            <input type="file" class="form-control"
                   accept="image/*"
                   id="door-material"
                   ref="doorImageRef"
                   @change="onChangePhotos('uploaded_door_image', $event)"
                   placeholder="name@example.com" multiple>
            <label for="door-material">Текстура материала для двери</label>
        </div>

        <div class="row">
            <div class="col-12" v-if="uploaded_door_image.length>0">
                <h6 class="font-bold my-3">Новые фотографии к материалу</h6>
            </div>
            <div class="col-md-4 mb-2 image-preview d-flex align-items-start" v-for="(variant, index) in uploaded_door_image">
                <div class="card w-100">
                    <img
                        style="min-height: 200px;"
                        :src="getPhoto(variant.image).imageUrl"
                        class="card-img-top uploaded-image-mini"
                        alt="">

                    <div class="card-body d-flex justify-center">
                        <a href="javascript:void(0)"  class="text-danger" @click="removePhoto('uploaded_door_image',index)">Удалить фото</a>
                    </div>

                    <div class="card-body">


                        <div class="form-floating mb-3 ">
                            <input type="text" v-model="uploaded_door_image[index].title"
                                   class="form-control border-gray-300 rounded-md" id="floatingInput" required>
                            <label for="floatingInput">Название</label>
                        </div>



                        <div class="form-floating">
                            <textarea class="form-control"
                                      v-model="uploaded_door_image[index].description"
                                      placeholder="Leave a comment here" id="floatingTextarea" required></textarea>
                            <label for="floatingTextarea">Описание</label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-12" v-if="form.door_variants.length>0">
                <h6 class="font-bold my-3">Текущие фотографии к материалу</h6>
            </div>
            <div class="col-md-4 mb-2 image-preview d-flex align-items-start" v-for="(variant, index) in form.door_variants">
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
                        <a href="javascript:void(0)" class="text-danger" @click="removeUploadedPhoto('door_variants',index)">Удалить</a>
                    </div>
                    <div class="card-body">


                        <div class="form-floating mb-3 ">
                            <input type="text" v-model="form.door_variants[index].title"
                                   class="form-control border-gray-300 rounded-md" id="floatingInput" required>
                            <label for="floatingInput">Название</label>
                        </div>



                        <div class="form-floating">
                            <textarea class="form-control"
                                      v-model="form.door_variants[index].description"
                                      placeholder="Leave a comment here" id="floatingTextarea" required></textarea>
                            <label for="floatingTextarea">Описание</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-floating mb-3 border-gray-100 border">
            <input type="file" class="form-control"
                   id="material-wrapper"
                   accept="image/*"
                   ref="wrapperImageRef"
                   @change="onChangePhotos('uploaded_wrapper_image', $event)"
                   placeholder="name@example.com" multiple>
            <label for="material-wrapper">Текстура материала вокруг двери</label>
        </div>

        <div class="row">
            <div class="col-12" v-if="uploaded_wrapper_image.length>0">
                <h6 class="font-bold my-3">Новые фотографии к материалу</h6>
            </div>
            <div class="col-md-6 mb-2 image-preview d-flex align-items-start" v-for="(variant, index) in uploaded_wrapper_image">
                <div class="card w-100 rounded-0">
                    <img
                        style="min-height: 200px;"
                        :src="getPhoto(variant.image).imageUrl"
                        class="card-img-top uploaded-image-mini"
                        alt="">

                    <div class="card-body d-flex justify-center">
                        <a href="javascript:void(0)"  class="text-danger" @click="removePhoto('uploaded_wrapper_image',index)">Удалить фото</a>
                    </div>

                    <div class="card-body ">


                        <div class="form-floating mb-2 ">
                            <input type="text" v-model="uploaded_wrapper_image[index].title"
                                   class="form-control rounded-0 border-gray-300" id="floatingInput">
                            <label for="floatingInput">Название</label>
                        </div>



                        <div class="form-floating">
                            <textarea class="form-control rounded-0"
                                      v-model="uploaded_wrapper_image[index].description"
                                      placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                            <label for="floatingTextarea">Описание</label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-12" v-if="form.wrapper_variants.length>0">
                <h6 class="font-bold my-3">Текущие фотографии к материалу</h6>
            </div>
            <div class="col-md-6 mb-2 image-preview d-flex align-items-start" v-for="(variant, index) in form.wrapper_variants">
                <div class="card w-100 p-1 rounded-0">
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
                        <a href="javascript:void(0)" class="text-danger" @click="removeUploadedPhoto('wrapper_variants',index)">Удалить</a>
                    </div>
                    <div class="card-body">


                        <div class="form-floating mb-2 ">
                            <input type="text" v-model="form.wrapper_variants[index].title"
                                   class="form-control border-gray-300 rounded-0" id="floatingInput" required>
                            <label for="floatingInput">Название</label>
                        </div>



                        <div class="form-floating">
                            <textarea class="form-control rounded-0"
                                      v-model="form.wrapper_variants[index].description"
                                      placeholder="Leave a comment here" id="floatingTextarea" required></textarea>
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
                    class="btn btn-dark rounded-0 ">
                    <i class="fa-regular fa-floppy-disk mr-1" v-if="!loading"></i>
                    <span class="spinner-border spinner-border-sm  text-success"
                          role="status" v-else></span>
                    Сохранить материал
                </button>
                <button
                    v-if="needClearForm&&!loading"
                    type="button"
                    @click="resetForm"
                    class="btn btn-outline-danger rounded-0 ml-2">
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
            uploaded_wrapper_image: [],
            uploaded_door_image: [],
            loading: false,
            form: {
                id: null,
                title: null,
                is_base: false,
                order_position: 0,
                need_generate_sizes: false,
                wrapper_variants: [],
                door_variants: [],
                config:{
                    is_custom_color:false
                }
            }
        }
    },
    computed: {
        needClearForm() {


            return this.form.id ||
                this.form.title ||
                this.uploaded_wrapper_image.length > 0 ||
                this.uploaded_door_image.length > 0
        }
    },
    mounted() {
      if (this.item)
          this.$nextTick(()=>{
              this.form = {
                  id: this.item.id || null,
                  title: this.item.title || null,
                  is_base: this.item.is_base || false,
                  order_position: this.item.order_position || 0,
                  config: this.item.config || {
                      is_custom_color: false
                  },

                  wrapper_variants: this.item.wrapper_variants || [],
                  door_variants: this.item.door_variants || [],
              }
          })
    },
    methods: {
        alert(msg) {
            this.messages.push(msg)
        },
        resetForm() {
            this.uploaded_wrapper_image = []
            this.uploaded_door_image = []

            this.form.id = null
            this.form.title = null
            this.form.order_position = 0
            this.form.is_base = false
            this.form.wrapper_variants = []
            this.form.door_variants = []
            this.form.config.is_custom_color = false

            this.$refs.doorImageRef.value = null
            this.$refs.wrapperImageRef.value = null

            this.$emit("callback")

        },
        removeUploadedPhoto(param, index){
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
                    image:files[i],
                    title:null,
                    description:null,
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


            if (this.uploaded_wrapper_image.length>0) {
                for (let i = 0; i < this.uploaded_wrapper_image.length; i++) {
                    data.append('wrapper_images[]', this.uploaded_wrapper_image[i].image);

                    this.uploaded_wrapper_image[i].image_name = this.uploaded_wrapper_image[i].image.name || null
                }


                data.append('wrapper_images_info', JSON.stringify(this.uploaded_wrapper_image));
            }

            /*   for (let i = 0; i < this.uploaded_wrapper_image.length; i++)
                   data.append('wrapper_images[]', this.uploaded_wrapper_image[i]);*/

            if (this.uploaded_door_image.length>0) {
                for (let i = 0; i < this.uploaded_door_image.length; i++) {
                    data.append('door_images[]', this.uploaded_door_image[i].image);

                    this.uploaded_door_image[i].image_name = this.uploaded_door_image[i].image.name || null
                }


                data.append('door_images_info', JSON.stringify(this.uploaded_door_image));
            }

            /*for (let i = 0; i < this.uploaded_door_image.length; i++)
                data.append('door_images[]', this.uploaded_door_image[i]);
*/

            this.$store.dispatch("storeMaterial", {
                materialForm: data
            }).then((response) => {
                this.resetForm()
                this.$emit("callback")
            }).catch(error => {
                this.alert(error.response.data.message)
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
