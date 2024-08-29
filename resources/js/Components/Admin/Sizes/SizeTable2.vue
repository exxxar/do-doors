<script setup>

    import { PerfectScrollbar } from 'vue3-perfect-scrollbar'
</script>
<template>
    <div class="row">
        <div class="col-12">
            <button class="btn-dark text-white btn btn-outline-secondary mr-2 rounded-0" @click="switchData('sizes')">Размеры</button>
            <button class="btn-dark text-white btn btn-outline-secondary mr-2 rounded-0" @click="switchData('loops')">Петли</button>
            <button class="btn-dark text-white btn btn-outline-secondary mr-2 rounded-0" @click="switchData('colors')">Цвет</button>
            <button class="btn-dark text-white btn btn-outline-secondary mr-2 rounded-0" @click="switchData('variants')">Толщина</button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <span class="badge  mr-2 cursor-pointer" @click="toggleMaterialId(material.id)"
                v-bind:class="{'bg-primary':selectedMaterials.indexOf(material.id)!=-1,'bg-secondary':selectedMaterials.indexOf(material.id)==-1}"
                v-for="material in materials"> {{ material.title }}</span>
        </div>

    </div>
    <PerfectScrollbar scrollTop class="py-2" v-if="prices.length>0&&selectedMaterials.length>0">
        <table>
            <thead>
                <tr>

                    <td rowspan="2" class="table-side-column">Высота</td>
                    <td rowspan="2" class="table-side-column">Ширина</td>


                    <template v-for="material in materials">
                        <td colspan="6" width="200px"
                            style="font-weight: bold;text-align: center;border:1px solid #dadada;"
                            v-if="selectedMaterials.indexOf(material.id)!=-1"> {{ material.title }}
                        </td>
                    </template>
                </tr>

                <tr>
                    <template v-for="material in materials">
                        <template v-if="selectedMaterials.indexOf(material.id)!=-1">
                            <td width="100px"
                                style="font-weight: bold;text-align: center;border:1px solid #dadada; min-width: 100px;">
                                Число петель</td>
                            <td width="100px"
                                style="font-weight: bold;text-align: center;border:1px solid #dadada; min-width: 100px;">
                                Опт</td>
                            <td width="100px"
                                style="font-weight: bold;text-align: center;border:1px solid #dadada; min-width: 100px;">
                                Дилер</td>
                            <td width="100px"
                                style="font-weight: bold;text-align: center;border:1px solid #dadada; min-width: 100px;">
                                Розница</td>
                            <td width="100px"
                                style="font-weight: bold;text-align: center;border:1px solid #dadada; min-width: 100px;">
                                Себестоимость</td>
                            <td width="100px" style="font-weight: bold;text-align: center;border:1px solid #dadada;">
                                Коэффициент
                            </td>
                        </template>
                    </template>
                </tr>


            </thead>
            <tbody>

                <tr  @click="openEditModal($event, item, index)" v-for="(item, index) in prices">
                    <td class="table-side-column"><span>{{ item.height }}</span></td>
                    <td class="table-side-column"><span>{{ item.width }}</span></td>

                    <template v-for="(price, priceIndex) in item.prices">

                        <template v-if="selectedMaterials.indexOf(price.material_id)!=-1">

                            <td :value=priceIndex style="text-align: center;border:1px solid #dadada;min-width: 100px;">
                                {{ item.prices[priceIndex].value || 0}}
                            </td>
                            <td :value=priceIndex style="text-align: center;border:1px solid #dadada;min-width: 100px;">
                                {{ item.prices[priceIndex].price.wholesale}}
                            </td>
                            <td :value=priceIndex style="text-align: center;border:1px solid #dadada;min-width: 100px;">
                                {{ item.prices[priceIndex].price.dealer}}
                            </td>
                            <td :value=priceIndex style="text-align: center;border:1px solid #dadada;min-width: 100px;">
                                {{ item.prices[priceIndex].price.retail}}
                            </td>
                            <td :value=priceIndex style="text-align: center;border:1px solid #dadada;min-width: 100px;">
                                {{ item.prices[priceIndex].price.cost}}
                            </td>
                            <td :value=priceIndex width="100px" style="text-align: center;border:1px solid #dadada;">
                                {{item.prices[priceIndex].price_koef}}
                            </td>


                        </template>

                    </template>
                </tr>
            </tbody>
        </table>
    </PerfectScrollbar>

    <div class="alert alert-success my-3" role="alert" v-if="selectedMaterials.length===0">
        <h4 class="alert-heading">Выберите материалы</h4>
        <p>Для отображения таблицы выберите интересующие материалы</p>
    </div>

    <div class="alert alert-success my-3" role="alert" v-if="prices.length===0">
        <h4 class="alert-heading">Размеры</h4>
        <p>К сожалению, раздел размеров пуст. Вы еще не добавили ни одного размера, который можно отобразить на этой
            странице.</p>
        <hr>
        <p class="mb-0">Воспользуйтесь формой выше и добавьте свой первый размер</p>
    </div>


    <div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">{{activeLink}} || {{activeMaterial}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" v-model="editableFieldsForm.activeItem.width" class="form-control"
                                    id="size-width" required>
                                <label for="size-width">Ширина, см</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" v-model="editableFieldsForm.activeItem.height" class="form-control"
                                    id="size-height" required>
                                <label for="size-height">Высота, см</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-floating mb-3">
                                <input  type="number" v-model="editableFieldsForm.activeItemPrices.value" class="form-control"
                                    id="size-price-wholesale" required>
                                <label for="size-price-wholesale">Число петель</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" v-model="editableFieldsForm.price.dealer" class="form-control"
                                    id="size-price-dealer" required>
                                <label for="size-price-dealer">Цена дилеру, руб</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" v-model="editableFieldsForm.price.wholesale" class="form-control"
                                    id="size-price-wholesale" required>
                                <label for="size-price-wholesale">Цена опт, руб</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" v-model="editableFieldsForm.price.retail" class="form-control"
                                    id="size-price-retail" required>
                                <label for="size-price-retail">Цена розница, руб</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" v-model="editableFieldsForm.price.cost" class="form-control"
                                    id="size-price-cost" required>
                                <label for="size-price-cost">Себестоимость, руб</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" v-model="editableFieldsForm.activeItemPrices.price_koef" step="0.1"
                                    class="form-control" id="size-price-koef" required>
                                <label for="size-price-koef">Ценовой коэффициент</label>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-outline-primary rounded-0">Сохранить изменения</button>
                    <button type="button" class="btn btn-outline-secondary rounded-0"
                        data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
    import { mapGetters } from "vuex";

    export default {
        data() {
            return {
                materials: [],
                prices: [],
                selectedMaterials: [],
                table: null,
                editModal: null,

                activeLink: null, //Размеры Петли Цвет Толщина
                activeMaterial: null,
                
                editableFieldsForm:  {

                    price: [],
                    activeItemPrices:[],
                    activeItem:[]
                }

            }
        },

        mounted() {
            this.loadSizes();
            this.editModal = new bootstrap.Modal(document.getElementById('edit-modal'), {})
        },
        methods: {

            getStringData(data) {

                switch (data) {
                    case "sizes":
                        return 'Размеры';
                    case "loops":
                        return 'Петли';
                    case "colors":
                        return 'Цвет';
                    case "variants":
                        return 'Толщина';
                    default:
                        return "Не определено"
                }
            },

            switchData(data) {
                this.prices = this.table[data]
                this.activeLink = this.getStringData(data)

            },
            toggleMaterialId(id) {
                let index = this.selectedMaterials.findIndex(item => item === id)

                if (index === -1)
                    this.selectedMaterials.push(id)
                else
                    this.selectedMaterials.splice(index, 1)
            },
            loadSizes(page = 0) {
                this.$store.dispatch("loadPreparedPrices").then(resp => {
                    this.table = resp
                    this.materials = resp.materials
                    this.prices = resp.loops
                    this.selectedMaterials = this.materials.map(o => o["id"]);

                }).catch(() => {

                })
            },
            openEditModal(event, item) {
                const target = event.target.closest('td');
                const priceIndex = target.getAttribute('value') || 0;
                this.activeMaterial = this.materials[priceIndex].title 
                this.activeLink = this.activeLink || "Петили"
                this.editableFieldsForm.activeItem = item
                this.editableFieldsForm.activeItemPrices = item.prices[priceIndex]
                this.editableFieldsForm.price = item.prices[priceIndex].price
                this.editableFieldsForm.countLoops = item.prices[priceIndex].value || 0
                
                this.editModal.show();
            },
            saveParam(param, index, priceIndex) {

                this.$store.dispatch("updateSizeParam", {
                    dataObject: {
                        id: this.prices[index].prices[priceIndex].id,
                        key: param,
                        value: this.prices[index].prices[priceIndex][param],
                        height: this.prices[index].prices[priceIndex].height || null,
                        width: this.prices[index].prices[priceIndex].width || null,
                        material_id: this.prices[index].prices[priceIndex].material_id || null,
                    },
                }).then(resp => {

                    if (!this.prices[index].prices[priceIndex].id)
                        this.prices[index].prices[priceIndex].id = resp.data.id

                    this.$notify({
                        title: "DoDoors",
                        text: "Параметры успешно обновлены",
                    });
                }).catch(() => {
                    // this.loading = false
                })
            }

        }
    }
</script>
<style lang="scss">
    @import 'vue3-perfect-scrollbar/style.css';

    .ps {
        //  max-height: 100px; /* or height: 100px; */
    }

    .ps__rail-x {
        top: 0px;
        bottom: auto;
        /* If using `top`, there shouldn't be a `bottom`. */
    }

    .ps__thumb-x {
        top: 2px;
        bottom: auto;
        /* If using `top`, there shouldn't be a `bottom`. */
    }

    .scrollable-area {
        width: 100%;
        overflow-y: auto;
    }

    .table-side-column {
        font-weight: bold;
        border: 1px solid #dadada;
        width: 72px;
        position: sticky;
        text-align: center;
        background-color: #ededed;
        padding: 0px 5px;


        &:nth-child(1) {
            left: 0px;
        }

        &:nth-child(2) {
            left: 68px;
        }

    }
</style>