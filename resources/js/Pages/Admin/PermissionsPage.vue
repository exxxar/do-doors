<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
;
import PermissionTable from "@/Components/Admin/Permissions/PermissionTable.vue";
import PermissionForm from "@/Components/Admin/Permissions/PermissionForm.vue";
import {Head} from '@inertiajs/vue3';
</script>

<template>
    <Head title="Разрешения"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Разрешения</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <PermissionForm
                            v-if="!loading"
                            :item="selectedPermission"
                            v-on:callback="callbackPermissionForm"></PermissionForm>
                        <hr class="hr my-5"/>
                        <PermissionTable
                            v-on:select="selectPermission"
                            v-if="!loading"></PermissionTable>
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
            selectedPermission: null,
        }
    },
    methods: {
        selectPermission(item) {
            this.selectedPermission = item;
            this.loading = true
            this.$nextTick(() => {
                this.loading = false
            })
        },
        callbackPermissionForm() {
            this.loading = true
            this.selectedPermission = null
            this.$nextTick(() => {
                this.loading = false
            })
        }
    }
}
</script>
