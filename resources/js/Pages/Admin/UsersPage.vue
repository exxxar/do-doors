<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import UserTable from "@/Components/Admin/Users/UserTable.vue";
import UserForm from "@/Components/Admin/Users/UserForm.vue";
import {Head} from '@inertiajs/vue3';
</script>

<template>
    <Head title="Пользователи"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Пользователи</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <UserForm
                            :id="'user-form-1'"
                            v-if="!loading"
                            :item="selectedUser"
                            v-on:callback="callbackUserForm"></UserForm>
                        <hr class="hr my-5"/>
                        <UserTable
                            v-on:select="selectUser"
                            v-if="!loading"></UserTable>
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
            selectedUser: null,
        }
    },
    methods: {
        selectUser(item) {
            this.selectedUser = item;
            this.loading = true
            this.$nextTick(() => {
                this.loading = false
            })
        },
        callbackUserForm() {
            this.loading = true
            this.selectedUser = null
            this.$nextTick(() => {
                this.loading = false
            })
        }
    }
}
</script>
