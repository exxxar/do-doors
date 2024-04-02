<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
;
import HandleTable from "@/Components/Admin/Handles/HandleTable.vue";
import HandleForm from "@/Components/Admin/Handles/HandleForm.vue";
import {Head} from '@inertiajs/vue3';
</script>

<template>
    <Head title="Ручки"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ручки</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <HandleForm
                            v-if="!loading"
                            :item="selectedHandle"
                            v-on:callback="callbackHandleForm"></HandleForm>
                        <hr class="hr my-5"/>
                        <HandleTable
                            v-on:select="selectHandle"
                            v-if="!loading"></HandleTable>
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
            selectedHandle: null,
        }
    },
    methods: {
        selectHandle(item) {
            this.selectedHandle = item;
            this.loading = true
            this.$nextTick(() => {
                this.loading = false
            })
        },
        callbackHandleForm() {
            this.loading = true
            this.selectedHandle = null
            this.$nextTick(() => {
                this.loading = false
            })
        }
    }
}
</script>
