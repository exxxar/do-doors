<template>

    <form action="" v-on:submit.prevent="submit">
        <div class="form-floating mb-3">
            <input type="text"
                   v-model="form.title"
                   class="form-control" id="hinge-title"
                   required>
            <label for="hinge-title">Наименование производителя петель</label>
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
                    Сохранить производителя петель
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

            form: {
                id: null,
                title: null,
                price: {
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
                this.form.price


        }
    },
    mounted() {

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


            this.$store.dispatch("storeHinge", {
                hingeForm: data
            }).then((response) => {
                this.$emit("callback")

                this.$store.dispatch("updatedFormattedSizes").then(resp => {
                    window.dispatchEvent(new CustomEvent("load-sizes", {
                        detail: null
                    }));
                    this.$notify({
                        title: "DoDoors",
                        text: "Вы успешно обновили данные",
                    });
                })

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
