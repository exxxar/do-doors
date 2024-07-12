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
        }
    }
}
</script>
