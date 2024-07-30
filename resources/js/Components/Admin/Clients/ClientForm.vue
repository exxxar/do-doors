<script setup>
    import UserTable from "@/Components/Admin/Users/UserTable.vue";
</script>
<template>

    <div class="row mb-3">
        <div class="col-md-6 col-12">
            <button type="button" class="btn btn-dark rounded-0" @click="resetForm">Очистить форму
            </button>
        </div>
    </div>
    <form action="" v-on:submit.prevent="submit">

        <div class="row">

            <div class="col-md-6 col-12">
                <div class="form-floating">
                    <select class="form-select" v-model="form.status" id="status"
                        aria-label="Floating label select example">
                        <option :value="null">Не выбрано</option>
                        <option :value="item.value" v-for="item in statuses">{{ item.title || 'Не указано' }}</option>
                    </select>
                    <label for="status">Тип контрагента</label>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-floating mb-3">
                    <input type="text" v-model="form.title" class="form-control" id="client-title" required>
                    <label for="client-title">Наименование компании</label>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-floating mb-3">
                    <input type="text" v-model="form.fio" class="form-control" id="client-title">
                    <label for="fio">ФИО представителя компании</label>
                </div>
            </div>

            <div class="col-6">
                <div class="form-floating mb-3">
                    <div class="form-floating">
                        <textarea class="form-control rounded-0 border-secondary" v-model="form.law_address"
                            placeholder="Leave a comment here" id="law_address"></textarea>
                        <label for="law_address">Юридический адрес</label>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="form-floating mb-3">
                    <input type="email" v-model="form.email" class="form-control" id="client-email">
                    <label for="client-email">Электронная почта</label>
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="form-floating mb-3">
                    <input type="text" v-model="form.phone" v-mask="'+7(###)###-##-##'" class="form-control"
                        id="client-phone">
                    <label for="client-phone">Телефон</label>
                </div>
            </div>

            <div class="col-md-12 col-12">
                <div class="form-floating mb-3">
                    <div class="form-floating">
                        <textarea class="form-control rounded-0 border-secondary" v-model="form.comment"
                            placeholder="Leave a comment here" id="comment"></textarea>
                        <label for="comment">Комментарий</label>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-12  mb-3">

                <div class="input-group ">

                    <div class="form-floating">
                        <input type="text" v-model="form.inn" maxlength="12" class="form-control" id="client-inn"
                            required>
                        <label for="client-inn">ИНН</label>
                    </div>

                    <button type="button" :disabled="!form.inn" @click="requestByInn"
                        class="btn btn-outline-secondary rounded-0"><i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>

                <a :href="'https://egrul.nalog.ru/vyp-download/'+link_for_document" target="_blank"
                    class="btn btn-link my-0 py-0 px-0" style="color:red;" v-if="link_for_document">Скачать выписку</a>


            </div>

            <div class="col-md-6 col-12">
                <div class="form-floating mb-3">
                    <input type="text" maxlength="9" v-model="form.kpp" class="form-control" id="client-kpp">
                    <label for="client-kpp">КПП</label>
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="form-floating mb-3">
                    <input type="text" maxlength="15" v-model="form.ogrn" class="form-control" id="client-ogrn">
                    <label for="client-ogrn">ОГРН</label>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-floating mb-3">
                    <input type="text" v-model="form.okpo" maxlength="10" class="form-control" id="client-okpo">
                    <label for="client-okpo">ОКПО</label>
                </div>
            </div>

            <div class="col-md-6 col-12  mb-3">

                <div class="input-group ">

                    <div class="form-floating " @click="openUserSearchModal">
                        <p class="form-control rounded-0 border-secondary" v-if="form.user">{{ form.user.email }}</p>
                        <p class="form-control rounded-0 border-secondary" v-else>Не выбран</p>
                        <label for="client-user_id">Пользователь</label>
                    </div>

                    <button type="button" class="btn btn-outline-secondary rounded-0" @click="form.user = null"
                        v-if="form.user"><i class="fa-solid fa-ban"></i></button>
                </div>


            </div>
        </div>


        <div class="row">
            <div class="col-12 my-2">
                <button type="button" @click="addRequisites" class="btn btn-dark rounded-0"><i
                        class="fa-solid fa-plus mr-1"></i>Добавить расчётный счёт
                </button>
            </div>
            <div class="col-md-6 col-12 mb-3" v-for="(item, index) in form.requisites">
                <div class="card rounded-0 border-secondary">
                    <div class="card-header d-flex justify-between align-items-center  border-secondary">

                        <div class="form-check form-switch ">
                            <input class="form-check-input" @change="changeRequisitesMain(index)"
                                v-model="form.requisites[index].is_main" type="checkbox" role="switch"
                                :id="'form-requisites-checking_account'+index" checked>
                            <label class="form-check-label" :for="'form-requisites-checking_account'+index">
                                Основной расчетный счёт
                            </label>
                        </div>

                        <a href="javascript:void(0)" class="btn btn-outline-secondary rounded-0"
                            @click="removeRequisite(index)"><i class="fa-solid fa-xmark mr-2"></i> Удалить</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="input-group mb-3">
                                    <div class="form-floating">
                                        <input type="text" maxlength="11" v-model="form.requisites[index].bik"
                                            class="form-control" :id="'form-requisites-bik'+index" required>
                                        <label :for="'form-requisites-bik'+index">БИК</label>
                                    </div>

                                    <button type="button" :disabled="!form.requisites[index].bik"
                                        @click="requestByBik(index)" class="btn btn-outline-secondary rounded-0"><i
                                            class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>


                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" v-model="form.requisites[index].bank" class="form-control"
                                        :id="'form-requisites-bank'+index">
                                    <label :for="'form-requisites-bank'+index">Банк</label>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" v-model="form.requisites[index].address" class="form-control"
                                        :id="'form-requisites-address'+index">
                                    <label :for="'form-requisites-address'+index">Адрес</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" maxlength="20"
                                        v-model="form.requisites[index].correspondent_account" class="form-control"
                                        :id="'form-requisites-correspondent_account'+index">
                                    <label :for="'form-requisites-correspondent_account'+index">Кор.счёт</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating">
                                    <input type="text" v-model="form.requisites[index].checking_account" maxlength="20"
                                        class="form-control" :id="'form-requisites-checking_account'+index" required>
                                    <label :for="'form-requisites-checking_account'+index">Расчетный счет</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-12">
                <div v-if="messages.length>0" v-for="(message, index) in messages"
                    class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Внимание!</strong> {{ message || 'Ошибка' }}
                    <button type="button" class="btn-close" @click="removeMessage(index)"></button>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                <button class="btn btn-dark rounded-0">
                    <i class="fa-regular fa-floppy-disk mr-1" v-if="!loading"></i>
                    <span class="spinner-border spinner-border-sm  text-success" role="status" v-else></span>
                    Сохранить клиента
                </button>
                <button v-if="!loading" type="button" @click="resetForm"
                    class="btn btn-outline-secondary rounded-0 ml-2">
                    <i class="fa-solid fa-xmark mr-1"></i>
                    Очистить клиента
                </button>

            </div>
        </div>
    </form>


    <!-- Modal -->
    <div class="modal fade " id="search-users" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content rounded-0 border-secondary">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Поиск пользователя</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body 0">
                    <UserTable :for-select="true" v-on:select="selectUserId"></UserTable>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-0 border-secondary"
                        data-bs-dismiss="modal">Закрыть
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mask } from 'vue-the-mask'
    import { mapGetters } from "vuex";

    export default {
        components: {},

        directives: { mask },
        props: ["item"],
        data() {
            return {
                messages: [],
                userSearchModal: null,
                loading: false,
                link_for_document: null,
                statuses: [],
                form: {
                    id: null,
                    status: null,
                    phone: null,
                    email: null,
                    fact_address: null,
                    comment: null,

                    user: null,
                    user_id: null,
                    title: null,
                    fio: null,
                    law_address: null,
                    inn: null,
                    kpp: null,
                    ogrn: null,
                    okpo: null,
                    requisites: []

                }
            }
        },
        computed: {
            ...mapGetters(["getDictionary"]),

        },
        mounted() {
            this.statuses = this.getDictionary.statuses || []

            this.userSearchModal = new bootstrap.Modal(document.getElementById('search-users'), {})

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
                        user: this.item.user || null,
                        title: this.item.title || null,
                        fio: this.item.fio || null,
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
            openUserSearchModal() {
                this.userSearchModal.show();
            },
            requestByBik(index) {
                this.$notify({
                    title: "DoDoors",
                    text: "Ищем по БИК...",
                });

                this.$store.dispatch("requestByBik", {
                    bik: this.form.requisites[index].bik
                }).then((response) => {

                    this.form.requisites[index].bank = (response.name || "").replaceAll("&quot;", "'")
                    this.form.requisites[index].address = response.address ? ((response.index || "") + ", "
                        + (response.city || "") + ", " + (response.address || "")) : null
                    this.form.requisites[index].correspondent_account = response.ks || null


                    this.$notify({
                        title: "DoDoors",
                        text: "Отлично! Данные найдены",
                        type: "success"
                    });

                }).catch(error => {

                    this.$notify({
                        title: "DoDoors",
                        text: "Данные не найдено",
                        type: "error"
                    });
                })
            },
            requestByInn() {
                this.link_for_document = null

                this.$notify({
                    title: "DoDoors",
                    text: "Ищем по ИНН...",
                });

                this.$store.dispatch("requestByInn", {
                    inn: this.form.inn
                }).then((response) => {

                    this.form.title = response[0].c || null
                    this.form.kpp = response[0].p || null
                    this.form.ogrn = response[0].o || null

                    let date = new Date()
                    this.link_for_document = (response[0].t || null) + `?r=${date.getTime()}&_=${date.getTime()}`

                    this.$notify({
                        title: "DoDoors",
                        text: "Отлично! Данные найдены",
                        type: "success"
                    });

                }).catch(error => {

                    this.$notify({
                        title: "DoDoors",
                        text: "Данные не найдено",
                        type: "error"
                    });
                })
            },
            changeRequisitesMain(index) {
                this.form.requisites.forEach(item => item.is_main = false)
                this.form.requisites[index].is_main = true
            },
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
            selectUserId(item) {
                this.form.user_id = item.id
                this.form.user = item
                this.userSearchModal.hide();
            },
            resetForm() {
                const fields = {
                    id: null,
                    status: null,
                    phone: null,
                    email: null,
                    fact_address: null,
                    comment: null,
                    user_id: null,
                    title: null,
                    fio: null,
                    law_address: null,
                    inn: null,
                    kpp: null,
                    ogrn: null,
                    okpo: null,
                    requisites: [],
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