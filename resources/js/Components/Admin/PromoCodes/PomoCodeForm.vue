<script setup>
import RalColorSelector from "@/Components/Support/RalColorSelector.vue";
</script>
<template>

    <form action="" v-on:submit.prevent="submit">
        <div class="form-floating mb-3">
            <input type="text"
                   v-model="form.code"
                   maxlength="5"
                   class="form-control" id="promo-code-code"
                   required>
            <label for="promo-code-code">Промокод</label>
        </div>

        <div class="form-floating mb-3">
            <input type="number"
                   v-model="form.discount"
                   step="0.01"
                   min="0"
                   max="100"
                   class="form-control" id="promo-code-discount"
                   required>
            <label for="promo-code-discount">Процент скидки</label>
        </div>

        <div class="form-floating mb-3">
            <textarea class="form-control border-secondary rounded-0"
                      v-model="form.description"
                      style="min-height: 100px;"
                      placeholder="Оставьте комментарий"
                      id="promo-code-comment">
            </textarea>
            <label for="promo-code-comment">Комментарий к промокоду</label>
        </div>

        <div class="form-check form-switch">
            <input class="form-check-input"
                   v-model="form.is_active"
                   type="checkbox" role="switch" id="promo-code-is-active" checked>
            <label class="form-check-label" for="promo-code-is-active">
               Доступен для активации
            </label>
        </div>


        <div class="row">
            <div class="col-12">
                <label class="form-check-label" for="promo-code-is-active">
                    Дата завершения
                </label>

                <VueDatePicker
                    locale="ru"
                    v-model="form.end_at">
                    <template #action-row="{ internalModelValue, selectDate,closePicker  }">
                        <div class="action-row">
                            <button
                                type="button"
                                class="btn btn-dark rounded-0 mr-2" @click="selectDate">Выбрать</button>
                            <button
                                type="button"
                                class="btn btn-outline-secondary rounded-0" @click="closePicker">Закрыть</button>
                        </div>
                    </template>

                </VueDatePicker>
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
                    Сохранить промокод
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
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
export default {
    props: ["item"],
    components: {VueDatePicker},
    data() {
        return {
            messages: [],
            loading: false,
            form: {
                id: null,
                code: null,
                description: null,
                discount: 0,
                end_at: null,
                is_active: true,
            }
        }
    },
    computed: {
        needClearForm() {
            return this.form.id ||
                this.form.code ||
                this.form.description ||
                this.form.discount ||
                this.form.end_at

        }
    },
    mounted() {

        if (this.item)
            this.$nextTick(() => {
                this.form = {
                    id: this.item.id || null,
                    code: this.item.code || null,
                    description: this.item.description || null,
                    discount: this.item.discount || 0,
                    end_at: this.item.end_at || null,
                    is_active: this.item.is_active || true,

                }
            })
    },
    methods: {

        alert(msg) {
            this.messages.push(msg)
        },
        resetForm() {

            this.form.id = null
            this.form.code = null
            this.form.discount = 0
            this.form.description = null
            this.form.end_at = null
            this.form.is_active = false

            this.$emit("callback")

        },
        removeMessage(index) {
            this.messages.splice(index, 1)
        },
        submit() {

            this.$store.dispatch("storePromoCode", {
                promoCodeForm: this.form
            }).then((response) => {

                this.$notify({
                    title: "DoDoors",
                    text: "Промокод успешно добавлен",
                    type:"success"
                });
                this.$emit("callback")
                this.resetForm()
            }).catch(error => {
                this.$notify({
                    title: "DoDoors",
                    text: "Ошибка добавления промокода",
                    type:"error"
                });
            })


        }
    }
}
</script>

<style>
.scrollable-area {
    width: 100%;
    overflow-y: auto;
}

:root {

    --dp-border-radius: 0px; /*Configurable border-radius*/
    --dp-cell-border-radius: 0px; /*Specific border radius for the calendar cell*/
    --dp-border-color: red;
}

.dp__theme_light {
    --dp-border-color: black;
    --dp-primary-color: #000000;
}

.action-row {
    display: flex;
    justify-content: center;
    width: 100%;
}
</style>
