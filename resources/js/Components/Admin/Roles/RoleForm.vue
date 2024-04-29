<script setup>
import RalColorSelector from "@/Components/Support/RalColorSelector.vue";
</script>
<template>

    <form action="" v-on:submit.prevent="submit">
        <div class="form-floating mb-3">
            <input type="text"
                   v-model="form.name"
                   class="form-control" id="role-name"
                   required>
            <label for="role-code">Название роли</label>
        </div>

        <div class="form-floating mb-3">
            <input type="text"
                   v-model="form.slug"
                   class="form-control" id="role-slug"
                   required>
            <label for="role-code">Программный идентификатор роли</label>
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
                    Сохранить роль
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
                name: null,
                slug: null,
            }
        }
    },
    computed: {
        needClearForm() {
            return this.form.id ||
                this.form.name ||
                this.form.slug

        }
    },
    mounted() {

        if (this.item)
            this.$nextTick(() => {
                this.form = {
                    id: this.item.id || null,
                    slug: this.item.slug || null,
                    name: this.item.name || null,

                }
            })
    },
    methods: {

        alert(msg) {
            this.messages.push(msg)
        },
        resetForm() {

            this.form.id = null
            this.form.name = null
            this.form.slug = 0
            this.$emit("callback")

        },
        removeMessage(index) {
            this.messages.splice(index, 1)
        },
        submit() {

            this.$store.dispatch("storeRole", {
                roleForm: this.form
            }).then((response) => {

                this.$notify({
                    title: "DoDoors",
                    text: "Роль успешно добавлена",
                    type:"success"
                });
                this.$emit("callback")
                this.resetForm()
            }).catch(error => {
                this.$notify({
                    title: "DoDoors",
                    text: "Ошибка добавления роли",
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
