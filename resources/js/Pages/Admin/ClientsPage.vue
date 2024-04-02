<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CalcForm from "@/Components/Calc/CalcForm.vue";
import SizeForm from "@/Components/Admin/Sizes/SizeForm.vue";
import SizeTable from "@/Components/Admin/Sizes/SizeTable.vue";
import SizeTable2 from "@/Components/Admin/Sizes/SizeTable2.vue";
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
