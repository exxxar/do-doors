<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CalcForm from "@/Components/Calc/CalcForm.vue";
import MaterialTable from "@/Components/Admin/Materials/MaterialTable.vue";
import MaterialForm from "@/Components/Admin/Materials/MaterialForm.vue";
import {Head} from '@inertiajs/vue3';
</script>

<template>
    <Head title="Материалы"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Материалы</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <MaterialForm
                            v-if="!loading"
                            :item="selectedMaterial"
                            v-on:callback="callbackMaterialForm"></MaterialForm>
                        <hr class="hr my-5"/>
                        <MaterialTable
                            v-on:select="selectMaterial"
                            v-if="!loading"></MaterialTable>
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
            selectedMaterial: null,
        }
    },
    methods: {
        selectMaterial(item) {
            this.selectedMaterial = item;
            this.loading = true
            this.$nextTick(() => {
                this.loading = false
            })
        },
        callbackMaterialForm() {
            this.loading = true
            this.selectedMaterial = null
            this.$nextTick(() => {
                this.loading = false
            })
        }
    }
}
</script>
