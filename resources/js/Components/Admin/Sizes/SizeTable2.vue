<script setup>

import {PerfectScrollbar} from 'vue3-perfect-scrollbar'
</script>
<template>
    <div class="row">
        <div class="col-12">
            <button @click="switchData('sizes')">Размеры</button>
            <button @click="switchData('loops')">Петли</button>
            <button @click="switchData('colors')">Цвет</button>
            <button @click="switchData('variants')">Толщина</button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <span class="badge  mr-2 cursor-pointer"
                  @click="toggleMaterialId(material.id)"
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
                    <td colspan="6" width="200px" style="font-weight: bold;text-align: center;border:1px solid #dadada;"
                        v-if="selectedMaterials.indexOf(material.id)!=-1"
                    > {{ material.title }}
                    </td>
                </template>
            </tr>

            <tr>
                <template v-for="material in materials">
                    <template v-if="selectedMaterials.indexOf(material.id)!=-1">
                        <td width="100px" style="font-weight: bold;text-align: center;border:1px solid #dadada; min-width: 100px;">Число петель</td>
                        <td width="100px" style="font-weight: bold;text-align: center;border:1px solid #dadada; min-width: 100px;">Опт</td>
                        <td width="100px" style="font-weight: bold;text-align: center;border:1px solid #dadada; min-width: 100px;">Дилер</td>
                        <td width="100px" style="font-weight: bold;text-align: center;border:1px solid #dadada; min-width: 100px;">Розница</td>
                        <td width="100px" style="font-weight: bold;text-align: center;border:1px solid #dadada; min-width: 100px;">Себестоимость</td>
                        <td width="100px" style="font-weight: bold;text-align: center;border:1px solid #dadada;">
                            Коэффициент
                        </td>
                    </template>
                </template>
            </tr>


            </thead>
            <tbody>

            <tr @click="openEditModal($event, item, index)" v-for="(item, index) in prices">
                <td class="table-side-column"><span>{{ item.height }}</span></td>
                <td class="table-side-column"><span>{{ item.width }}</span></td>

                <template v-for="(price, priceIndex) in item.prices">

                    <template  v-if="selectedMaterials.indexOf(price.material_id)!=-1">
                        
                        <td :value =priceIndex  style="text-align: center;border:1px solid #dadada;min-width: 100px;">
                            {{ item.prices[priceIndex].value || 0}}
                        </td>
                        <td :value =priceIndex style="text-align: center;border:1px solid #dadada;min-width: 100px;">
                           {{ item.prices[priceIndex].price.wholesale}}
                        </td>
                        <td :value =priceIndex style="text-align: center;border:1px solid #dadada;min-width: 100px;">
                            {{ item.prices[priceIndex].price.dealer}}
                        </td>
                        <td :value =priceIndex style="text-align: center;border:1px solid #dadada;min-width: 100px;">
                            {{ item.prices[priceIndex].price.retail}}
                        </td>
                        <td :value =priceIndex style="text-align: center;border:1px solid #dadada;min-width: 100px;">
                            {{ item.prices[priceIndex].price.cost}}
                        </td>
                        <td :value =priceIndex width="100px" style="text-align: center;border:1px solid #dadada;">
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


<div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md ">
            <div class="modal-content rounded-0">

                <div class="modal-body ">
                    <!-- <MaterialTable
                        :simple="true"
                        v-on:select="selectMaterial"
                        v-if="!loadingMaterial"></MaterialTable> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-0" data-bs-dismiss="modal">Закрыть
                    </button>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
import {mapGetters} from "vuex";

export default {
    data() {
        return {
            materials: [],
            prices: [],
            selectedMaterials: [],
            table:null,
            editModal: null,
            
        }
    },

    mounted() {
        this.loadSizes();
        this.editModal = new bootstrap.Modal(document.getElementById('edit-modal'), {})
    },
    methods: {
        

        switchData(data){
            this.prices = this.table[data]
            
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
                this.selectedMaterials =    this.materials.map(o => o["id"]);

            }).catch(() => {

            })
        },
        openEditModal(event, item, index) {
            // item[index].prices[price_index]
            
            // console.log(index)
            const target = event.target.closest('td');
            
            const priceIndex = target.getAttribute('value');

            console.log(priceIndex)
            console.log(item.prices[priceIndex])
            
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
