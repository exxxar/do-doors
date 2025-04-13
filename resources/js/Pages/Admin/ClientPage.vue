<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import ClientTable from "@/Components/Admin/Clients/ClientTable.vue";
import ClientForm from "@/Components/Admin/Clients/ClientForm.vue";
import {Head} from '@inertiajs/vue3';

defineProps(["client"]);
</script>

<template>
    <Head title="Редактирование клиента"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактирование клиента</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <ClientForm
                            :editing="true"
                            v-if="!loading"
                            :item="client"
                            v-on:callback="callbackClientForm"></ClientForm>
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

        }
    },
    methods: {
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
