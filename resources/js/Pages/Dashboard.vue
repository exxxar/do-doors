<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import CalcForm from "@/Components/Calc/CalcForm.vue";
import CalcSwitch from "@/Components/Calc/CalcSwitch.vue";
import SizeControls from "@/Components/Admin/Sizes/SizeControls.vue";
</script>

<template>
    <Head title="Главная" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Главная</h2>
        </template>


        <div class="py-12">
            <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm rounded-0">
                    <div class="p-6 text-gray-900">
                        <SizeControls></SizeControls>
<!--                     <CalcSwitch></CalcSwitch>-->
                        <CalcForm></CalcForm>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
