<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import ClientTable from "@/Components/Admin/Clients/ClientTable.vue";
import ClientForm from "@/Components/Admin/Clients/ClientForm.vue";
import {Head} from '@inertiajs/vue3';
import SellerInfoEditor from "@/Components/Admin/Documents/SellerInfoEditor.vue";
import Contracts from "@/Components/Admin/Documents/Contracts.vue";
</script>

<template>
    <Head title="Документы"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Документы</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <SellerInfoEditor></SellerInfoEditor>
                        <Contracts></Contracts>
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

    }
}
</script>
