<template>
    <div
        @click="showFilterModal"
        class="card rounded-0 border-black cursor-pointer">
        <div class="card-body px-2 py-1">

            <label class="font-size-10"><i class="fa-solid fa-ruler-vertical"></i> Выбор завертки</label>
            <p v-if="door">{{ door.handle_wrapper_type?.title || 'не выбрано' }}</p>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="wrapper-filter-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Варианты заверток</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" v-if="door">
                    <button type="button"
                            class="btn btn-outline-secondary w-100 rounded-0 p-3 mb-2"
                            @click="reset">Не выбрано
                    </button>


                    <h6 v-if="new_wrappers.length>0" class="fw-bold mb-2">Добавленные завертки <span
                        class="small text-secondary">{{ new_wrappers.length }}/10</span></h6>

                    <template v-for="(item, index) in new_wrappers" :key="'handle'+index">
                        <div class="input-group mb-2">

                            <button
                                @click="selectWrapper(item)"
                                class="btn border-black rounded-0" type="button"><i class="fa-solid fa-arrow-left"></i> Выбрать
                            </button>

                            <div class="form-floating">
                                <input type="text" class="form-control" :id="'fast-new-wrapper-title-'+index"
                                       v-model="new_wrappers[index].title">
                                <label :for="'fast-new-wrapper-title-'+index">Название</label>
                            </div>


                            <div class="form-floating">
                                <input type="number" class="form-control" :id="'fast-new-wrapper-price-'+index"
                                       v-model="new_wrappers[index].price">
                                <label :for="'fast-new-wrapper-price-'+index">Цена, руб</label>
                            </div>

                            <button
                                @click="removeHandle(index)"
                                class="btn btn-dark rounded-0" type="button">Удалить
                            </button>
                        </div>
                    </template>

                    <div class="d-flex flex-start">
                        <button
                            type="button"
                            :disabled="new_wrappers.length>=10"
                            @click="addNewHandle"
                            v-bind:class="{'btn-outline-dark':new_wrappers.length>0,'btn-dark':new_wrappers.length===0}"
                            class="btn  rounded-0 mb-3"><i class="fa-solid fa-plus"></i> Добавить новую завертку
                        </button>

                    </div>
                    <ul class="list-group">
                    <div v-for="(item, index) in filteredItems" :key="item.title"
                         class="list-group-item cursor-pointer"
                         :class="{'list-group-item-primary': door.handle_wrapper_type === item,
                             'list-group-item-success':success_added.indexOf(item.title)!=-1&&item.id!=null,
                             'list-group-item-warning':success_added.indexOf(item.title)!=-1&&item.id==null,

                             }"
                    >
                        <a href="javascript:void(0)"
                           @click="editWrapper(item)"
                           class="mr-2">
                            <i class="fa-solid fa-pen-to-square text-success"
                               v-if="edited_wrapper?.id!==item.id"></i>
                            <i class="fa-solid fa-xmark text-danger" v-else></i>
                        </a>
                        <span @click="selectWrapper(item)">
                                 {{ item.title }}

                            </span>
                        <template v-if="edited_wrapper?.id === item.id">
                            <form v-on:submit.prevent="saveEditedHandle">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control"
                                           :id="'edit-fast-new-handle-title-'+item.id"
                                           v-model="edited_wrapper.title" required>
                                    <label :for="'edit-fast-new-handle-title-'+item.id">Название</label>
                                </div>

                                <div class="input-group mb-2">

                                    <div class="form-floating">
                                        <input type="number" class="form-control"
                                               :id="'edit-fast-new-handle-price-wholesale-'+item.id"
                                               v-model="edited_wrapper.price.wholesale" required>
                                        <label :for="'edit-fast-new-handle-price-wholesale-'+item.id">Оптовая цена,
                                            руб</label>
                                    </div>

                                    <div class="form-floating">
                                        <input type="number" class="form-control"
                                               :id="'edit-fast-new-handle-price-dealer-'+item.id"
                                               v-model="edited_wrapper.price.dealer" required>
                                        <label :for="'edit-fast-new-handle-price-dealer-'+item.id">Цена дилера,
                                            руб</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="number" class="form-control"
                                               :id="'edit-fast-new-handle-price-retail-'+item.id"
                                               v-model="edited_wrapper.price.retail" required>
                                        <label :for="'edit-fast-new-handle-price-retail-'+item.id">Розничная цена,
                                            руб</label>
                                    </div>

                                    <div class="form-floating">
                                        <input type="number" class="form-control"
                                               :id="'edit-fast-new-handle-price-cost-'+item.id"
                                               v-model="edited_wrapper.price.cost" required>
                                        <label :for="'edit-fast-new-handle-price-cost-'+item.id">Себестоимость,
                                            руб</label>
                                    </div>
                                </div>


                                <div class="d-flex justify-content-between">
                                    <button
                                        :disabled="edit_loading"
                                        class="btn btn-dark rounded-0" type="submit">
                                        <i
                                            v-if="!edit_loading"
                                            class="fa-solid fa-floppy-disk mr-2"></i>
                                        <div id="preloader"
                                             v-if="edit_loading"
                                             class="d-inline-flex justify-content-center align-items-center mr-2">
                                            <div class="spinner-border spinner-border-sm text-white" role="status">
                                                <span class="visually-hidden">Загрузка...</span>
                                            </div>
                                        </div>
                                        Сохранить

                                    </button>
                                    <button
                                        :disabled="edit_loading"
                                        @click="removeSelectedHandle"
                                        class="btn bg-danger text-white rounded-0" type="button">
                                        <i v-if="!edit_loading" class="fa-solid fa-trash-can mr-2"></i>
                                        <div
                                            v-if="edit_loading"
                                            id="preloader"
                                            class="d-inline-flex justify-content-center align-items-center mr-2">
                                            <div class="spinner-border spinner-border-sm text-white" role="status">
                                                <span class="visually-hidden">Загрузка...</span>
                                            </div>
                                        </div>
                                        Удалить завертку

                                    </button>
                                </div>

                            </form>

                        </template>
                    </div>
                    </ul>



                </div>

            </div>
        </div>
    </div>
</template>
<script>
import {mapGetters} from "vuex";

export default {
    props: ["modelValue"],
    data() {
        return {
            door: null,
            edit_loading: false,
            edited_wrapper: null,
            success_added: [],
            filter_modal: null,
            new_wrappers: [],
            searchQuery: '',
            new_handles: [],
        }
    },
    watch: {
        'door': {
            handler(val) {
                this.$emit('update:modelValue', this.door)
            },
            deep: true
        }
    },
    computed: {
        ...mapGetters(['getDictionary', 'cartTotalCount']),
        filteredItems() {
            return this.getDictionary.handle_holes_type_variants.filter(item =>
                (item.title) ? item.title.toLowerCase().includes(this.searchQuery.toLowerCase()) : ''
            ).reverse();
        }

    },
    mounted() {
        this.filter_modal = new bootstrap.Modal(document.getElementById('wrapper-filter-modal'));
        this.door = this.modelValue


    },
    methods: {

        editWrapper(wrapper) {

            if (this.edited_wrapper && this.edited_wrapper?.id === wrapper.id) {
                this.edited_wrapper = null
                return;
            }

            this.edited_wrapper = null
            this.$nextTick(() => {
                this.edited_wrapper = wrapper
            })
        },
        reloadHandles() {
            this.$store.dispatch("updatedFormattedSizes").then(resp => {
                window.dispatchEvent(new CustomEvent("load-sizes", {
                    detail: null
                }));
                this.$notify({
                    title: "DoDoors",
                    text: "Вы успешно обновили данные",
                });
            })
        },
        removeSelectedHandle() {
            if (!this.edited_wrapper)
                return;

            this.edit_loading = true
            this.$store.dispatch("removeHandle", {
                handleId: this.edited_wrapper.id
            }).then(() => {
                this.edit_loading = false
                this.reloadHandles()
            }).catch(() => {
                this.edit_loading = false
            })

        },
        saveEditedHandle() {
            if (!this.edited_wrapper)
                return;

            this.edit_loading = true
            this.$store.dispatch("fastEditHandle", {
                handle: this.edited_wrapper
            }).then((response) => {
                this.$notify({
                    title: "DoDoors",
                    text: "Вы сохранили данные по ручке",
                });

                this.edit_loading = false
                this.edited_wrapper = null
                this.reloadHandles()
            }).catch(error => {
                this.edit_loading = false
                this.$notify({
                    title: "DoDoors",
                    text: "Ошибка сохранения ручки",
                    type: 'error'
                });
            })
        },
        showFilterModal() {
            this.edited_wrapper = null
            this.filter_modal.show()
        },
        selectWrapper(wrapper) {
            let index = this.success_added.findIndex(item => item === wrapper.title)

            if (index != -1)
                this.success_added.splice(index, 1)

            this.door.handle_wrapper_type = wrapper == null ? {title: null} : wrapper

            this.edited_wrapper = null;
            this.filter_modal.hide()
        },

        removeHandle(index) {
            this.new_wrappers.splice(index, 1)
        },
        addNewHandle() {
            this.new_wrappers.push({
                title: '',
                price: 0,
            })
        },
        reset() {
            this.edited_wrapper = null
            this.filter_modal.hide()
            this.door.handle_wrapper_type = {title: null}
            this.searchQuery = ''
        }
    }
}
</script>
