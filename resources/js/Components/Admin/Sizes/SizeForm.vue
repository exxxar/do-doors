<script setup>
import MaterialTable from "@/Components/Admin/Materials/MaterialTable.vue";
</script>
<template>

    <form action="" v-on:submit.prevent="submit">

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-floating mb-3">
                    <input type="number"
                           v-model="form.width"
                           class="form-control" id="size-width"
                           required>
                    <label for="size-width">Ширина, см</label>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-floating mb-3">
                    <input type="number"
                           v-model="form.height"
                           class="form-control" id="size-height"
                           required>
                    <label for="size-height">Высота, см</label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-floating mb-3">
                    <input type="number"
                           v-model="form.price.wholesale"
                           class="form-control" id="size-price-wholesale"
                           required>
                    <label for="size-price-wholesale">Цена опт, руб</label>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="form-floating mb-3">
                    <input type="number"
                           v-model="form.price.dealer"
                           class="form-control" id="size-price-dealer"
                           required>
                    <label for="size-price-dealer">Цена дилеру, руб</label>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="form-floating mb-3">
                    <input type="number"
                           v-model="form.price.wholesale"
                           class="form-control" id="size-price-wholesale"
                           required>
                    <label for="size-price-wholesale">Цена опт, руб</label>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="form-floating mb-3">
                    <input type="number"
                           v-model="form.price.retail"
                           class="form-control" id="size-price-retail"
                           required>
                    <label for="size-price-retail">Цена розница, руб</label>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="form-floating mb-3">
                    <input type="number"
                           v-model="form.price.cost"
                           class="form-control" id="size-price-cost"
                           required>
                    <label for="size-price-cost">Себестоимость, руб</label>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="form-floating mb-3">
                    <input type="number"
                           v-model="form.price_koef"
                           step="0.1"
                           class="form-control" id="size-price-koef"
                           required>
                    <label for="size-price-koef">Ценовой коэффициент</label>
                </div>
            </div>
        </div>


        <div class="form-floating mb-3">
            <input type="number"
                   v-model="form.loops_count"
                   class="form-control" id="size-loops-count"
                   placeholder="name@example.com">
            <label for="size-loops-count">Число петель</label>
        </div>

        <p class="mb-2" v-if="selectedMaterial">Вы выбрали материал: <strong>{{
                selectedMaterial.title || '-'
            }}</strong>
            <a href="javascript:void(0)" @click="removeSelectedMaterial"><i
                class="fa-solid fa-xmark ml-1 text-danger"></i></a>
        </p>
        <button type="button" class="btn btn-outline-primary" @click="openMaterialModal">
            <i class="fa-solid fa-scroll mr-2"></i> Выберите материал
        </button>


        <div class="row mt-2">
            <div class="col-12">
                <div
                    v-if="messages.length>0"
                    v-for="(message, index) in messages"
                    class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Внимание!</strong> {{ message || 'Ошибка' }}
                    <button type="button" class="btn-close"
                            @click="removeMessage(index)"></button>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                <button
                    :disabled="!needClearForm||form.material_id == null"
                    class="btn btn-dark rounded-0">
                    <i class="fa-regular fa-floppy-disk mr-1" v-if="!loading"></i>
                    <span class="spinner-border spinner-border-sm  text-success"
                          role="status" v-else></span>
                    Сохранить размер
                </button>
                <button
                    v-if="needClearForm&&!loading"
                    type="button"
                    @click="resetForm"
                    class="btn btn-outline-secondary rounded-0 ml-2">
                    <i class="fa-solid fa-xmark mr-1"></i>
                    Очистить форму
                </button>

            </div>
        </div>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="select-material-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-body">
                    <MaterialTable
                        v-on:select="selectMaterial"
                        v-if="!loadingMaterial"></MaterialTable>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["item"],
    data() {
        return {
            materialModal: null,
            messages: [],
            loading: false,
            loadingMaterial: false,
            selectedMaterial: null,
            form: {
                id: null,
                width: 0,
                height: 0,
                material_id: null,
                price: {
                    wholesale: 0,
                    dealer: 0,
                    retail: 0,
                    cost: 0,
                },
                price_koef: 0,
                loops_count: 0,
            }
        }
    },
    computed: {
        needClearForm() {
            return this.form.id ||
                this.form.width ||
                this.form.height ||
                this.form.size_id ||
                this.form.price ||
                this.form.price_koef ||
                this.form.loops_count

        }
    },
    mounted() {
        this.materialModal = new bootstrap.Modal(document.getElementById('select-material-modal'), {})

        if (this.item)
            this.$nextTick(() => {
                this.form = {
                    id: this.item.id || null,
                    width: this.item.width || null,
                    height: this.item.height || null,
                    size_id: this.item.size_id || null,
                    price: this.item.price || {
                        wholesale: 0,
                        dealer: 0,
                        retail: 0,
                        cost: 0,
                    },
                    price_koef: this.item.price_koef || null,
                    loops_count: this.item.loops_count || null,
                    material_id: this.item.material_id || null,
                }

                this.selectedMaterial = this.item.material || null
            })
    },
    methods: {
        removeSelectedMaterial() {
            this.selectedMaterial = null
            this.form.material_id = null
        },
        openMaterialModal() {
            this.materialModal.show();
        },
        selectMaterial(item) {
            this.selectedMaterial = item;
            this.form.material_id = item.id
            this.loadingMaterial = true
            this.$nextTick(() => {
                this.loadingMaterial = false
            })
            this.materialModal.hide();
        },
        alert(msg) {
            this.messages.push(msg)
        },
        resetForm() {
            this.form = {
                id: this.item.id || null,
                width: this.item.width || null,
                height: this.item.height || null,
                size_id: this.item.size_id || null,
                price: this.item.price || {

                    wholesale: 0,
                    dealer: 0,
                    retail: 0,
                    cost: 0,

                },
                price_koef: this.item.price_koef || null,
                loops_count: this.item.loops_count || null,
            }
            this.$emit("callback")
        },
        removeMessage(index) {
            this.messages.splice(index, 1)
        },
        submit() {
            let data = new FormData();
            Object.keys(this.form)
                .forEach(key => {
                    const item = this.form[key] || ''
                    if (typeof item === 'object')
                        data.append(key, JSON.stringify(item))
                    else
                        data.append(key, item)
                });

            this.$store.dispatch("storeSize", {
                sizeForm: data
            }).then((response) => {
                this.resetForm()
                this.$emit("callback")
            }).catch(error => {
                if (error.response)
                    this.alert(error.response.data.message)
                else
                    this.alert("Ошибка")
            })


        }
    }
}
</script>
<style lang="scss">
.uploaded-image-mini {
    width: 100%;
    object-fit: contain;
    max-height: 200px;
}

.image-preview {
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;


    & > .shadow {
        display: none;
        position: absolute;
        z-index: 1;
        background-color: rgba(0, 0, 0, 0.5);
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;

        a {
            color: white;
        }
    }

    &:hover {
        .shadow {
            display: flex;
        }
    }
}
</style>
