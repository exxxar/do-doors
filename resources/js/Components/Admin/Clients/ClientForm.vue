<template>

    <form action="" v-on:submit.prevent="submit">

        <div class="row">

            <div class="col-md-6 col-12">
                <div class="form-floating">
                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                    <label for="floatingSelect">Тип контрагента</label>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-floating mb-3">
                    <input type="text"
                           v-model="form.title"
                           class="form-control" id="client-title"
                           required>
                    <label for="client-title">Наименование компании \ Ф.И.О.</label>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-floating mb-3">
                    <input type="text"
                           v-model="form.law_address"
                           class="form-control" id="client-law_address">
                    <label for="client-title">Юридический адрес</label>
                </div>
            </div>
        </div>


        <div class="form-floating mb-3">
            <input type="number"
                   v-model="form.price"
                   class="form-control" id="client-price"
                   required>
            <label for="client-title">Цена ручки</label>
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
                    class="btn btn-outline-success rounded-5">
                    <i class="fa-regular fa-floppy-disk mr-1" v-if="!loading"></i>
                    <span class="spinner-border spinner-border-sm  text-success"
                          role="status" v-else></span>
                    Сохранить клиента
                </button>
                <button
                    v-if="!loading"
                    type="button"
                    @click="resetForm"
                    class="btn btn-outline-danger rounded-5 ml-2">
                    <i class="fa-solid fa-xmark mr-1"></i>
                    Очистить клиента
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
            statuses: [
                {
                    title: '',
                    value: ''
                }
            ],
            form: {
                id: null,
                status: null,
                phone: null,
                email: null,
                fact_address: null,
                comment: null,

                user_id: null,
                title: null,
                law_address: null,
                inn: null,
                kpp: null,
                ogrn: null,
                okpo: null,
                requisites: []

            }
        }
    },
    computed: {},
    mounted() {
        if (this.item)
            this.$nextTick(() => {
                this.form = {
                    id: this.item.id || null,
                    status: this.item.status || null,
                    phone: this.item.phone || null,
                    email: this.item.email || null,
                    fact_address: this.item.fact_address || null,
                    comment: this.item.comment || null,

                    user_id: this.item.user_id || null,
                    title: this.item.title || null,
                    law_address: this.item.law_address || null,
                    inn: this.item.inn || null,
                    kpp: this.item.kpp || null,
                    ogrn: this.item.ogrn || null,
                    okpo: this.item.okpo || null,
                    requisites: this.item.requisites || [],

                }
            })
    },
    methods: {
        alert(msg) {
            this.messages.push(msg)
        },
        removeRequisite(index) {
            this.form.requisites.splice(index, 1)
        },
        addRequisites() {
            this.form.requisites.push({
                bik: null,
                bank: null,
                address: null,
                correspondent_account: null,
                checking_account: null,
                is_main: false,
            })
        },
        resetForm() {
            const fields = {
                id: this.item.id || null,
                status: this.item.status || null,
                phone: this.item.phone || null,
                email: this.item.email || null,
                fact_address: this.item.fact_address || null,
                comment: this.item.comment || null,
                user_id: this.item.user_id || null,
                title: this.item.title || null,
                law_address: this.item.law_address || null,
                inn: this.item.inn || null,
                kpp: this.item.kpp || null,
                ogrn: this.item.ogrn || null,
                okpo: this.item.okpo || null,
                requisites: this.item.requisites || [],
            }

            this.form = fields

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


            this.$store.dispatch("storeClient", {
                clientForm: data
            }).then((response) => {
                this.$emit("callback")
                this.resetForm()
            }).catch(error => {

            })


        }
    }
}
</script>
