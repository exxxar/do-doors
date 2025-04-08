<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import ServiceTable from "@/Components/Admin/Services/ServiceTable.vue";
import ServiceForm from "@/Components/Admin/Services/ServiceForm.vue";
import {Head} from '@inertiajs/vue3';
</script>

<template>
    <Head title="Сервисы"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Сервисы</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <button
                            class="my-3 p-3 border-gray-100 border btn rounded-0"
                            type="button"
                            @click="importServicesFromMoySklad">
                            <i class="fa-solid fa-file-import" v-if="!moysklad_loading"></i>
                            <div v-else class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            Загрузить данные из Мой Склад
                        </button>
                        <ServiceForm
                            v-if="!loading"
                            :item="selectedService"
                            v-on:callback="callbackServiceForm"></ServiceForm>
                        <hr class="hr my-5"/>
                        <ServiceTable
                            v-on:select="selectService"
                            v-if="!loading"></ServiceTable>
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
            moysklad_loading: false,
            selectedService: null,
        }
    },
    methods: {
        selectService(item) {
            this.selectedService = item;
            this.loading = true
            this.$nextTick(() => {
                this.loading = false
            })
        },
        callbackServiceForm() {
            this.loading = true
            this.selectedService = null
            this.$nextTick(() => {
                this.loading = false
            })
        },
        importServicesFromMoySklad(){
            this.$notify({
                title: "DoDoors",
                text: "Началась загрузка данных",
            });

            this.moysklad_loading = true

            this.$store.dispatch("importServicesFromMoySklad")
                .then(()=>{
                    this.$notify({
                        title: "DoDoors",
                        text: "Данные успешно загружены",
                        type: "success",
                    });

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
        }
    }
}
</script>
