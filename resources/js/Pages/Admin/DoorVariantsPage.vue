<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import DoorVariantTable from "@/Components/Admin/DoorVariants/DoorVariantTable.vue";
import DoorVariantForm from "@/Components/Admin/DoorVariants/DoorVariantForm.vue";
import {Head} from '@inertiajs/vue3';
</script>

<template>
    <Head title="Варианты дверей"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Варианты дверей</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <DoorVariantForm
                            v-if="!loading"
                            :item="selectedDoorVariant"
                            v-on:callback="callbackDoorVariantForm"></DoorVariantForm>
                        <hr class="hr my-5"/>
                        <DoorVariantTable
                            v-on:select="selectDoorVariant"
                            v-if="!loading"></DoorVariantTable>
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
            selectedDoorVariant: null,
        }
    },
    methods: {
        selectDoorVariant(item) {
            this.selectedDoorVariant = item;
            this.loading = true
            this.$nextTick(() => {
                this.loading = false
            })
        },
        callbackDoorVariantForm() {
            this.loading = true
            this.selectedDoorVariant = null
            this.$nextTick(() => {
                this.loading = false
            })
        }
    }
}
</script>
