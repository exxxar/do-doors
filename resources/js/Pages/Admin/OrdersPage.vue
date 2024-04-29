<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import OrderTable from "@/Components/Admin/Orders/OrderTable.vue";
import OrderForm from "@/Components/Admin/Orders/OrderForm.vue";
import {Head} from '@inertiajs/vue3';
</script>

<template>
    <Head title="Заказы"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Заказы</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
<!--                        <OrderForm
                            v-if="!loading"
                            :item="selectedOrder"
                            v-on:callback="callbackOrderForm"></OrderForm>
                        <hr class="hr my-5"/>-->
                        <OrderTable
                            v-on:select="selectOrder"
                            v-if="!loading"></OrderTable>
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
            selectedOrder: null,
        }
    },
    methods: {
        selectOrder(item) {
            this.selectedOrder = item;
            this.loading = true
            this.$nextTick(() => {
                this.loading = false
            })
        },
        callbackOrderForm() {
            this.loading = true
            this.selectedOrder = null
            this.$nextTick(() => {
                this.loading = false
            })
        }
    }
}
</script>
