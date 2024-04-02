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
                        <h1 class="mb-3">Laravel 8 User Roles and Permissions Step by Step Tutorial - codeanddeploy.com</h1>

                        <div class="bg-light p-4 rounded">
                            <h2>Permissions</h2>
                            <div class="lead">
                                Manage your permissions here.
                                <a :href="route('permissions.create')" class="btn btn-primary btn-sm float-right">Add permissions</a>
                            </div>

                            <div class="mt-2">
                                @include('layouts.partials.messages')
                            </div>

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col" width="15%">Name</th>
                                    <th scope="col">Guard</th>
                                    <th scope="col" colspan="3" width="1%"></th>
                                </tr>
                                </thead>
                                <tbody>
    <!--                                @foreach($permissions as $permission)
                                    <tr>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ $permission->guard_name }}</td>
                                        <td><a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-info btn-sm">Edit</a></td>
                                        <td>
                                            {!! Form::open(['method' => 'DELETE','route' => ['permissions.destroy', $permission->id],'style'=>'display:inline']) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                    @endforeach-->
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
