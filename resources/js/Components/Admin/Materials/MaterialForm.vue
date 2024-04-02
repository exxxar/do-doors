<template>

    <form action="" v-on:submit.prevent="submit">
        <div class="form-floating mb-3">
            <input type="text"
                   v-model="form.title"
                   class="form-control" id="material-title"
                   placeholder="name@example.com" required>
            <label for="material-title">Название материала</label>
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
                <h6>Новые фотографии к материалу</h6>
            </div>
            <div class="col-md-3 mb-2 image-preview" v-for="(image, index) in uploaded_door_image">
                <img :src="getPhoto(image).imageUrl"
                     class="uploaded-image-mini"
                     alt="">

                <div class="shadow justify-content-center align-items-center">
                    <a href="javascript:void(0)" @click="removePhoto('uploaded_door_image',index)">Удалить</a>
                </div>
            </div>
            <div class="col-12" v-if="form.door_variants.length>0">
                <h6>Текущие фотографии к материалу</h6>
            </div>
            <div class="col-md-3 mb-2 image-preview" v-for="(image, index) in form.door_variants">
                <img :src="'/images/'+image"
                     class="uploaded-image-mini"
                     alt="">

                <div class="shadow justify-content-center align-items-center">
                    <a href="javascript:void(0)" @click="removeUploadedPhoto('door_variants',index)">Удалить</a>
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
                <h6>Новые фотографии к материалу</h6>
            </div>
            <div class="col-md-3 mb-2 image-preview" v-for="(image, index) in uploaded_wrapper_image">
                <img :src="getPhoto(image).imageUrl"
                     class="uploaded-image-mini"
                     alt="">
                <div class="shadow justify-content-center align-items-center">
                    <a href="javascript:void(0)" @click="removePhoto('uploaded_door_image',index)">Удалить</a>
                </div>
            </div>
            <div class="col-12" v-if="form.wrapper_variants.length>0">
                <h6>Текущие фотографии к материалу</h6>
            </div>
            <div class="col-md-3 mb-2 image-preview" v-for="(image, index) in form.wrapper_variants">
                <img :src="'/images/'+image"
                     class="uploaded-image-mini"
                     alt="">

                <div class="shadow justify-content-center align-items-center">
                    <a href="javascript:void(0)" @click="removeUploadedPhoto('wrapper_variants',index)">Удалить</a>
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
                    Сохранить материал
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
            uploaded_wrapper_image: [],
            uploaded_door_image: [],
            loading: false,
            form: {
                id: null,
                title: null,
                wrapper_variants: [],
                door_variants: []
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
            this.form.wrapper_variants = []
            this.form.door_variants = []

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


            for (let i = 0; i < this.uploaded_wrapper_image.length; i++)
                data.append('wrapper_images[]', this.uploaded_wrapper_image[i]);

            for (let i = 0; i < this.uploaded_door_image.length; i++)
                data.append('door_images[]', this.uploaded_door_image[i]);


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
