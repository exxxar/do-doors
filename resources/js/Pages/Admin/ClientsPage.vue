<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import ClientTable from "@/Components/Admin/Clients/ClientTable.vue";
import ClientForm from "@/Components/Admin/Clients/ClientForm.vue";
import {Head} from '@inertiajs/vue3';
</script>

<template>
    <Head title="Клиенты"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Клиенты</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <button
                            class="my-3 p-3 border-gray-100 border btn rounded-0"
                            type="button"
                            @click="importClientsFromMoySklad">
                            <i class="fa-solid fa-file-import" v-if="!moysklad_loading"></i>
                            <div v-else class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            Загрузить данные из Мой Склад
                        </button>
                        <a
                            v-if="import_success"
                            class="my-3 p-3 border-gray-100 border btn rounded-0 mx-2"
                            href="/moyscklad-client-log.txt" target="_blank">Лог операции</a>
                        <ClientForm
                            v-if="!loading"
                            :item="selectedClient"
                            v-on:callback="callbackClientForm"></ClientForm>
                        <hr class="hr my-5"/>
                        <ClientTable
                            v-on:select="selectClient"
                            v-if="!loading"></ClientTable>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script>
export default {
    data() {
        return {
            loading: false,
            import_success: false,
            moysklad_loading: false,
            selectedClient: null,
        }
    },
    methods: {
        importClientsFromMoySklad(){
            this.$notify({
                title: "DoDoors",
                text: "Началась загрузка данных",
            });

            this.moysklad_loading = true
            this.import_success = false
            this.$store.dispatch("importClientsFromMoySklad")
                .then(()=>{
                    this.$notify({
                        title: "DoDoors",
                        text: "Данные успешно загружены",
                        type: "success",
                    });

                    this.import_success = true
                    this.loading = true
                    this.$nextTick(()=>{
                        this.loading = false
                        this.moysklad_loading = false
                    })
                })
                .catch(()=>{
                    this.$notify({
                        title: "DoDoors",
                        text: "Ошибка загрузки данных",
                        type: "error",
                    });

                    this.moysklad_loading = false
                })
        },
        selectClient(item) {
            this.selectedClient = item;
            this.loading = true
            this.$nextTick(() => {
                this.loading = false
            })
        },
        callbackClientForm() {
            this.loading = true
            this.selectedClient = null
            this.$nextTick(() => {
                this.loading = false
            })
        }
    }
}
</script>
