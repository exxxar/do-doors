<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CartForm from "@/Components/Cart/CartForm.vue";
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Калькулятор" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Корзина</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900" v-if="tab===0">
                        <CartForm v-on:callback="tab++"></CartForm>
                    </div>
                    <div class="p-6 text-gray-900" v-if="tab===1">

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script>
export default {
    data(){
        return {
            tab:0,
        }
    }
}
</script>
