<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import HingeTable from "@/Components/Admin/Hinges/HingeTable.vue";
import HingeForm from "@/Components/Admin/Hinges/HingeForm.vue";
import {Head} from '@inertiajs/vue3';
</script>

<template>
    <Head title="Петли"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Петли</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <HingeForm
                            v-if="!loading"
                            :item="selectedHinge"
                            v-on:callback="callbackHingeForm"></HingeForm>
                        <hr class="hr my-5"/>
                        <HingeTable
                            v-on:select="selectHinge"
                            v-if="!loading"></HingeTable>
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
            selectedHinge: null,
        }
    },
    methods: {
        selectHinge(item) {
            this.selectedHinge = item;
            this.loading = true
            this.$nextTick(() => {
                this.loading = false
            })
        },
        callbackHingeForm() {
            this.loading = true
            this.selectedHinge = null
            this.$nextTick(() => {
                this.loading = false
            })
        }
    }
}
</script>
