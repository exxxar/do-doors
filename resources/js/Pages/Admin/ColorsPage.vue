<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import ColorTable from "@/Components/Admin/Colors/ColorTable.vue";
import ColorForm from "@/Components/Admin/Colors/ColorForm.vue";
import {Head} from '@inertiajs/vue3';
</script>

<template>
    <Head title="Цвета"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Цвета</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <ColorForm
                            v-if="!loading"
                            :item="selectedColor"
                            v-on:callback="callbackColorForm"></ColorForm>
                        <hr class="hr my-5"/>
                        <ColorTable
                            v-on:select="selectColor"
                            v-if="!loading"></ColorTable>
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
            selectedColor: null,
        }
    },
    methods: {
        selectColor(item) {
            this.selectedColor = item;
            this.loading = true
            this.$nextTick(() => {
                this.loading = false
            })
        },
        callbackColorForm() {
            this.loading = true
            this.selectedColor = null
            this.$nextTick(() => {
                this.loading = false
            })
        }
    }
}
</script>
