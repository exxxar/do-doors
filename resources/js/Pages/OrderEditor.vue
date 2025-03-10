<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import CalcPreview from "@/Components/Calc/CalcPreview.vue";
defineProps(['doors','order'])
</script>

<template>
    <Head title="Информация о заказе" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактирование заказа</h2>
        </template>


        <div class="py-12">
            <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm rounded-0">
                    <div class="p-6 text-gray-900">
                        <CalcPreview
                            :can-edit="true"
                            :doors="doors"
                            :order="order"></CalcPreview>
                    </div>
                </div>
            </div>
        </div>


    </AuthenticatedLayout>
</template>
