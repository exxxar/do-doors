<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UserTable from "@/Components/Admin/Users/UserTable.vue";
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
                        <UserTable></UserTable>
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
        }
    },
    methods: {

    }
}
</script>
