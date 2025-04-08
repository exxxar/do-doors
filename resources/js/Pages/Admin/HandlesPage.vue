<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
;
import HandleTable from "@/Components/Admin/Handles/HandleTable.vue";
import HandleForm from "@/Components/Admin/Handles/HandleForm.vue";
import {Head} from '@inertiajs/vue3';
import HandlesUploadModal from "@/Components/Admin/Handles/HandlesUploadModal.vue";
</script>

<template>
    <Head title="Ручки"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ручки</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-6 text-gray-900">
                        <HandlesUploadModal></HandlesUploadModal>
                        <button
                            class="my-3 p-3 border-gray-100 border btn rounded-0 mx-2"
                            type="button"
                            @click="importHandlesFromMoySklad">
                            <i class="fa-solid fa-file-import" v-if="!moysklad_loading"></i>
                            <div v-else class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            Загрузить данные из Мой Склад
                        </button>
                        <HandleForm
                            v-if="!loading"
                            :item="selectedHandle"
                            v-on:callback="callbackHandleForm"></HandleForm>
                        <hr class="hr my-5"/>
                        <HandleTable
                            v-on:select="selectHandle"
                            v-if="!loading"></HandleTable>
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
            selectedHandle: null,
        }
    },
    mounted() {
        this.$store.dispatch("loadRalColors")
    },
    methods: {
        importHandlesFromMoySklad(){
            this.$notify({
                title: "DoDoors",
                text: "Началась загрузка данных",
            });

            this.moysklad_loading = true

            this.$store.dispatch("importHandlesFromMoySklad")
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
        },
        selectHandle(item) {
            this.selectedHandle = item;
            this.loading = true
            this.$nextTick(() => {
                this.loading = false
            })
        },
        callbackHandleForm() {
            this.loading = true
            this.selectedHandle = null
            this.$nextTick(() => {
                this.loading = false
            })
        }
    }
}
</script>
