<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CalcForm from "@/Components/Calc/CalcForm.vue";
import SizeForm from "@/Components/Admin/Sizes/SizeForm.vue";
import SizeTable from "@/Components/Admin/Sizes/SizeTable.vue";
import SizeTable2 from "@/Components/Admin/Sizes/SizeTable2.vue";
import {Head} from '@inertiajs/vue3';
</script>

<template>
    <Head title="Размеры"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Размеры</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <SizeForm
                            :id="'size-form-1'"
                            :need-controls="true"
                            v-if="!loading"
                            :item="selectedSize"
                            v-on:callback="callbackSizeForm"></SizeForm>
                        <hr class="hr my-5"/>

<!--                        <div class="d-flex justify-center my-2">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page"
                                       v-bind:class="{'active':tab===0}"
                                       @click="tab=0"
                                       href="javascript:void(0)">Таблица размеров</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link"
                                       v-bind:class="{'active':tab===1}"
                                       @click="tab=1"
                                       href="javascript:void(0)">Сводная таблица</a>
                                </li>

                            </ul>
                        </div>-->
                        <template v-if="tab===0">
                            <SizeTable
                                v-on:select="selectSize"
                                v-if="!loading"></SizeTable>
                        </template>

                        <template v-if="tab===1">
                            <SizeTable2></SizeTable2>
                        </template>

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
            tab:0,
            loading: false,
            selectedSize: null,
        }
    },
    methods: {
        selectSize(item) {
            this.selectedSize = item;
            this.loading = true
            this.$nextTick(() => {
                this.loading = false
            })
        },
        callbackSizeForm() {
            this.loading = true
            this.selectedSize = null
            this.$nextTick(() => {
                this.loading = false
            })
        }
    }
}
</script>
