
<template>

    <form action="" v-on:submit.prevent="submit">
        <div class="form-floating mb-3">
            <input type="text"
                   v-model="form.title"
                   class="form-control" id="service-title"
                   required>
            <label for="service-title">Наименование варианта двери</label>
        </div>

        <div class="form-floating mb-3">
            <input type="text"
                   v-model="form.description"
                   class="form-control" id="service-description">
            <label for="service-description">Пояснение к параметру</label>
        </div>

        <div class="form-check form-switch mb-3">
            <input class="form-check-input"
                   v-model="form.is_active"
                   type="checkbox" role="switch" id="service-is_active">
            <label class="form-check-label" for="service-is_active">
               Отображается в калькуляторе
            </label>
        </div>

        <div class="form-floating mb-3">
            <select class="form-select"
                    v-model="form.type"
                    id="service-type" aria-label="Floating label select example">
                <option :value="item.value" v-for="item in types">{{item.title || '-'}}</option>
            </select>
            <label for="service-type">Тип сервиса</label>
        </div>


        <div class="form-floating mb-3">
            <input type="text"
                   v-model="form.order_position"
                   class="form-control" id="service-order_position">
            <label for="service-order_position">Позиция в выдаче</label>
        </div>

        <div class="card rounded-0 mb-3 border-black">
            <div class="card-header bg-dark text-white rounded-0 ">
                <h6>Настройка цены</h6>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">
                            <input type="number"
                                   v-model="form.price.wholesale"
                                   class="form-control" id="price-wholesale"
                                   required>
                            <label for="price-wholesale">Опт<span v-if="form.need_percent_price">, %</span><span v-else>, руб</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">
                            <input type="number"
                                   v-model="form.price.retail"
                                   class="form-control" id="price-retail"
                                   required>
                            <label for="price-retail">Розница<span v-if="form.need_percent_price">, %</span><span v-else>, руб</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <div class="form-floating">
                            <input type="number"
                                   v-model="form.price.dealer"
                                   class="form-control" id="price-dealer"
                                   required>
                            <label for="price-dealer">Дилер<span v-if="form.need_percent_price">, %</span><span v-else>, руб</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating">
                            <input type="number"
                                   v-model="form.price.cost"
                                   class="form-control" id="price-cost"
                                   required>
                            <label for="price-cost">Себестоимость<span v-if="form.need_percent_price">, %</span><span v-else>, руб</span>
                            </label>
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
                    Сохранить сервис
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


</template>
<script>
export default {
    props: ["item"],
    data() {
        return {
            messages: [],

            loading: false,
            types:[
                {
                    title:"Работа с ручками",
                    value:"service_handle",
                },

                {
                    title:"Работа со стопором",
                    value:"service_stopper",
                },
                {
                    title:"Работа с порогом",
                    value:"service_doorstep",
                },
                {
                    title:"Работа с доводчиком",
                    value:"service_door_closer",
                },
                {
                    title:"Работа с плинтусом",
                    value:"service_baseboard",
                },
                {
                    title:"Установка двери",
                    value:"service_door_install",
                },
                {
                    title:"Упаковка двери",
                    value:"service_door_wrapper",
                },
                {
                    title:"Покраска элементов",
                    value:"service_painting",
                }
            ],
            form: {
                id: null,
                title: null,
                description: null,
                type: null,
                order_position: 0,
                is_active: true,
                price:  {
                    wholesale: 0,
                    dealer: 0,
                    retail: 0,
                    cost: 0,
                },


            }
        }
    },
    computed: {
        needClearForm() {
            return this.form.id ||
                this.form.title ||
                this.form.description ||
                this.form.order_position ||
                this.form.type
        }
    },
    mounted() {

        if (this.item)
            this.$nextTick(() => {
                this.form = {
                    id: this.item.id || null,
                    title: this.item.title || null,
                    description: this.item.description || null,
                    is_active: this.item.is_active || true,
                    type: this.item.type || null,
                    order_position: this.item.order_position || 0,
                    price: this.item.price || {
                        wholesale: 0,
                        dealer: 0,
                        retail: 0,
                        cost: 0,
                    },


                }
            })
    },
    methods: {


        alert(msg) {
            this.messages.push(msg)
        },
        resetForm() {

            this.form.id = null
            this.form.title = null
            this.form.description = null
            this.form.type = null
            this.form.order_position = 0
            this.form.is_active = false
            this.form.price =   {
                wholesale: 0,
                dealer: 0,
                retail: 0,
                cost: 0,
            }

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


            this.$store.dispatch("storeService", {
                serviceForm: data
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
