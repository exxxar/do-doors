<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CalcForm from "@/Components/Calc/CalcForm.vue";
import { Head } from '@inertiajs/vue3';

defineProps(['order_id'])
</script>

<template>
    <Head title="Калькулятор" />

    <AuthenticatedLayout :order-id="order_id">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Калькулятор</h2>
        </template>


        <div class="py-12">
            <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white  shadow-sm rounded-0">
                    <div class="p-6 text-gray-900">
                        <CalcForm></CalcForm>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
