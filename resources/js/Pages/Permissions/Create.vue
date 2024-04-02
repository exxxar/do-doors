<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CalcForm from "@/Components/Calc/CalcForm.vue";
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Разрешения" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Калькулятор</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="bg-light p-4 rounded">
                            <h2>Add new permission</h2>
                            <div class="lead">
                                Add new permission.
                            </div>

                            <div class="container mt-4">

                                <form method="POST" action="{{ route('permissions.store') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input value="{{ old('name') }}"
                                               type="text"
                                               class="form-control"
                                               name="name"
                                               placeholder="Name" required>

<!--                                        @if ($errors->has('name'))
                                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                                        @endif-->
                                    </div>

                                    <button type="submit" class="btn btn-primary">Save permission</button>
                                    <a href="{{ route('permissions.index') }}" class="btn btn-default">Back</a>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
