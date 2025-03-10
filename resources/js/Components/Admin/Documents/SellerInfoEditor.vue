<script setup>
import SellerDataForm from "@/Components/Admin/Documents/SellerDataForm.vue";
</script>
<template>
    <h4 class="font-bold mb-2">Информация о продавце</h4>
    <form v-on:submit.prevent="storeDocumentConfig" class="mb-2">
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-tabs mb-2" id="sellerTabs" role="tablist">
                    <li class="nav-item " role="presentation">
                        <button class="nav-link rounded-0 active" id="ip-tab" data-bs-toggle="tab" data-bs-target="#ip" type="button" role="tab">ИП</button>
                    </li>
                    <li class="nav-item " role="presentation">
                        <button class="nav-link rounded-0" id="ooo-tab" data-bs-toggle="tab" data-bs-target="#ooo" type="button" role="tab">ООО</button>
                    </li>
                </ul>
            </div>
            <div class="col-12">

                <div class="tab-content" id="sellerTabsContent">
                    <div class="tab-pane fade show active" id="ip" role="tabpanel">
                        <SellerDataForm v-model="formData.seller.individual_entrepreneur"></SellerDataForm>
                    </div>
                    <div class="tab-pane fade" id="ooo" role="tabpanel">
                        <SellerDataForm  v-model="formData.seller.limited_liability_company"></SellerDataForm>
                    </div>
                </div>

            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-dark p-3 rounded-0 w-100">Сохранить</button>
            </div>
        </div>
    </form>
</template>


<script>
export default {
    data() {
        return {
            formData: {
                seller: {
                    individual_entrepreneur: {
                        title: "ИП Попова Светлана Владимировна",
                        INN_KPP: "760213171495",
                        OGRN: "314583802800012",
                        legal_address: {
                            postal_code: "442960",
                            city: "г. Заречный",
                            street: "ул. Конституции СССР",
                            building: "39г-67"
                        },
                        bank: {
                            name: "АО \"Тинькофф Банк\"",
                            BIC: "044525974",
                            correspondent_account: "30101810145250000974",
                            checking_account: "40802810200000015526"
                        },
                        email: "dodoors@yandex.ru",
                        phone: "+7(999)000-00-00"
                    },
                    limited_liability_company: {
                        title: "ООО \"ДуДорс\"",
                        INN_KPP: "5838015942/583801001",
                        OGRN: "1235800002987",
                        legal_address: {
                            postal_code: "442961",
                            region: "Пензенская обл.",
                            city: "г. Заречный",
                            street: "ул. Индустриальная",
                            building: "д. 9А"
                        },
                        bank: {
                            name: "АО \"Тинькофф Банк\"",
                            BIC: "44525974",
                            correspondent_account: "30101810145250000974",
                            checking_account: "40702810110001367926"
                        },
                        email: "dodoors@yandex.ru",
                        phone: "+7(999)000-00-00",
                        supplier_representative: {
                            full_name: "Попов Дмитрий Андреевич"
                        }
                    }

                }
            }
        };
    },
    mounted() {
        this.loadDocumentConfig()
    },
    methods: {
        loadDocumentConfig() {
            this.$store.dispatch("loadDocumentConfig").then(resp => {
                this.formData.seller = JSON.parse(resp.seller)
            }).catch(() => {

            })
        },
        storeDocumentConfig() {
            let data = new FormData();
            Object.keys(this.formData)
                .forEach(key => {
                    const item = this.formData[key] || ''
                    if (typeof item === 'object')
                        data.append(key, JSON.stringify(item))
                    else
                        data.append(key, item)
                });


            this.$store.dispatch("storeDocumentConfig", {
                form: data
            }).then((response) => {

                this.$notify({
                    title: "DoDoors",
                    text: "Настройки успешно сохранены!",
                    type: 'success'
                });

            }).catch(error => {
                this.$notify({
                    title: "DoDoors",
                    text: "Ошибочка...",
                    type: 'error'
                });
            })
        }
    }
};
</script>
