<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
;
import PromoCodeTable from "@/Components/Admin/PromoCodes/PromoCodeTable.vue";
import PromoCodeForm from "@/Components/Admin/PromoCodes/PomoCodeForm.vue";
import {Head} from '@inertiajs/vue3';
</script>

<template>
    <Head title="Промокоды"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Промокоды</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <PromoCodeForm
                            v-if="!loading"
                            :item="selectedPromoCode"
                            v-on:callback="callbackPromoCodeForm"></PromoCodeForm>
                        <hr class="hr my-5"/>
                        <PromoCodeTable
                            v-on:select="selectPromoCode"
                            v-if="!loading"></PromoCodeTable>
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
            selectedPromoCode: null,
        }
    },
    methods: {
        selectPromoCode(item) {
            this.selectedPromoCode = item;
            this.loading = true
            this.$nextTick(() => {
                this.loading = false
            })
        },
        callbackPromoCodeForm() {
            this.loading = true
            this.selectedPromoCode = null
            this.$nextTick(() => {
                this.loading = false
            })
        }
    }
}
</script>
