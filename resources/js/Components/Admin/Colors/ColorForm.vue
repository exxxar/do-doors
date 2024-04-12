<script setup>
import RalColorSelector from "@/Components/Support/RalColorSelector.vue";
</script>
<template>

    <form action="" v-on:submit.prevent="submit">
        <div class="form-floating mb-3">
            <input type="text"
                   v-model="form.title"
                   class="form-control" id="color-title"
                   required>
            <label for="color-title">Наименование цвета</label>
        </div>

        <div class="form-floating mb-3">
            <input type="number"
                   v-model="form.price"
                   class="form-control" id="color-price"
                   required>
            <label for="color-title">Цена</label>
        </div>

        <div class="input-group mb-3">

            <div class="form-floating">
                <input type="text"
                       v-model="form.code"
                       class="form-control" id="color-code">
                <label for="color-title">Код цвета</label>
            </div>
            <button
                type="button"
                @click="selectColor"
                class="btn btn-outline-secondary rounded-0" id="basic-addon1"><i class="fa-solid fa-palette"></i></button>
        </div>


        <div class="form-floating mb-3">
            <select class="form-select"
                    @invalid="alert('Вы не выбрали вариант использования!')"
                    v-model="form.type"
                    id="floatingSelect" aria-label="Floating label select example" required>
                <option :value="null">Выберите один из вариантов</option>
                <option :value="item.key" v-for="item in types">{{
                        item.title
                    }}
                </option>
            </select>
            <label for="floatingSelect">Вариант применения</label>
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
                    Сохранить цвет
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
    <div class="modal fade" :id="'choose-color'" tabindex="-1" aria-labelledby="exampleModalLabel"
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

            loading: false,
            colorModal: null,
            types: [
                {
                    title: 'Для всех',
                    key: 'all'
                },
                {
                    title: 'Отделка сторон',
                    key: 'side_finish'
                },
                {
                    title: 'Короб и каркас',
                    key: 'box_and_frame'
                },

                {
                    title: 'Фурнитура',
                    key: 'fittings'
                },

                {
                    title: 'Уплотнитель',
                    key: 'seal'
                },

            ],
            form: {
                id: null,
                title: null,
                price: null,
                code: null,
                type: null,


            }
        }
    },
    computed: {
        needClearForm() {
            return this.form.id ||
                this.form.title ||
                this.form.price ||
                this.form.code ||
                this.form.type

        }
    },
    mounted() {

        if (this.item)
            this.$nextTick(() => {
                this.form = {
                    id: this.item.id || null,
                    title: this.item.title || null,
                    price: this.item.price || 0,
                    code: this.item.code || null,
                    type: this.item.type || null,
                }
            })
    },
    methods: {

        callbackSelectColor(item) {
            this.form.title = item.names.en || item.color.code
            this.form.code = item.color.code || item.color.hex || null
            this.colorModal.hide()
        },
        selectColor() {
            this.colorModal = new bootstrap.Modal(document.getElementById('choose-color'), {})
            this.colorModal.show()
        },

        alert(msg) {
            this.messages.push(msg)
        },
        resetForm() {

            this.form.id = null
            this.form.title = null
            this.form.price = 0
            this.form.code = null
            this.form.type = null

            this.$emit("callback")

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


            this.$store.dispatch("storeColor", {
                colorForm: data
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
