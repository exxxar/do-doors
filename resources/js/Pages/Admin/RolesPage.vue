<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
;
import RoleTable from "@/Components/Admin/Roles/RoleTable.vue";
import RoleForm from "@/Components/Admin/Roles/RoleForm.vue";
import {Head} from '@inertiajs/vue3';
</script>

<template>
    <Head title="Роли"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Роли</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <RoleForm
                            v-if="!loading"
                            :item="selectedRole"
                            v-on:callback="callbackRoleForm"></RoleForm>
                        <hr class="hr my-5"/>
                        <RoleTable
                            v-on:select="selectRole"
                            v-if="!loading"></RoleTable>
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
            selectedRole: null,
        }
    },
    methods: {
        selectRole(item) {
            this.selectedRole = item;
            this.loading = true
            this.$nextTick(() => {
                this.loading = false
            })
        },
        callbackRoleForm() {
            this.loading = true
            this.selectedRole = null
            this.$nextTick(() => {
                this.loading = false
            })
        }
    }
}
</script>
