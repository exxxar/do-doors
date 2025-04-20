<template>
    <div
        @click="showFilterModal"
        class="card rounded-0 border-black cursor-pointer">
        <div class="card-body px-2 py-1 ">

            <label class="font-size-10"><i class="fa-solid fa-ruler-vertical"></i> Выбор ручки</label>
            <p v-if="door">{{ door.handle_holes_type?.title || 'не выбрано' }}</p>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="handlers-filter-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Варианты ручек</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" v-if="door">
                    <button type="button"
                            class="btn btn-outline-secondary w-100 rounded-0 p-3 mb-2"
                            @click="reset">Не выбрано
                    </button>
                    <div class="form-floating mb-3">
                        <input type="search" class="form-control" id="searchInput" placeholder="Поиск..."
                               v-model="searchQuery">
                        <label for="searchInput">Поиск...</label>
                    </div>

                    <h6 v-if="new_handles.length>0" class="fw-bold mb-2">Добавленные ручки <span
                        class="small text-secondary">{{ new_handles.length }}/10</span></h6>

                    <template v-for="(item, index) in new_handles" :key="'handle'+index">
                        <div class="input-group mb-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" :id="'fast-new-handle-title-'+index"
                                       v-model="new_handles[index].title">
                                <label :for="'fast-new-handle-title-'+index">Название</label>
                            </div>


                            <div class="form-floating">
                                <input type="number" class="form-control" :id="'fast-new-handle-price-'+index"
                                       v-model="new_handles[index].price">
                                <label :for="'fast-new-handle-price-'+index">Цена, руб</label>
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
                            @click="saveHandles"
                            v-if="new_handles.length>0"
                            class="btn btn-dark rounded-0 mb-3 mr-2"><i class="fa-solid fa-floppy-disk"></i> Сохранить
                        </button>

                        <button
                            type="button"
                            :disabled="new_handles.length>=10"
                            @click="addNewHandle"
                            v-bind:class="{'btn-outline-dark':new_handles.length>0,'btn-dark':new_handles.length===0}"
                            class="btn  rounded-0 mb-3"><i class="fa-solid fa-plus"></i> Добавить новую ручку
                        </button>

                    </div>


                    <div class="list-group">
                        <div v-for="(item, index) in filteredItems" :key="item.title"
                             class="list-group-item cursor-pointer"
                             :class="{'list-group-item-primary': door.handle_holes_type === item,
                             'list-group-item-success':success_added.indexOf(item.title)!=-1&&item.id!=null,
                             'list-group-item-warning':success_added.indexOf(item.title)!=-1&&item.id==null,

                             }"
                        >
                            <a href="javascript:void(0)"
                               @click="editHandle(item)"
                               class="mr-2">
                                <i class="fa-solid fa-pen-to-square text-success"
                                   v-if="edited_handle?.id!==item.id"></i>
                                <i class="fa-solid fa-xmark text-danger" v-else></i>
                            </a>

                            <span @click="selectHandle(item)">
                                 {{ item.title }}
                            </span>

                            <template v-if="edited_handle?.id === item.id">
                                <form v-on:submit.prevent="saveEditedHandle">
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control"
                                               :id="'edit-fast-new-handle-title-'+item.id"
                                               v-model="edited_handle.title" required>
                                        <label :for="'edit-fast-new-handle-title-'+item.id">Название</label>
                                    </div>

                                    <div class="input-group mb-2">

                                        <div class="form-floating">
                                            <input type="number" class="form-control"
                                                   :id="'edit-fast-new-handle-price-wholesale-'+item.id"
                                                   v-model="edited_handle.price.wholesale" required>
                                            <label :for="'edit-fast-new-handle-price-wholesale-'+item.id">Оптовая цена,
                                                руб</label>
                                        </div>

                                        <div class="form-floating">
                                            <input type="number" class="form-control"
                                                   :id="'edit-fast-new-handle-price-dealer-'+item.id"
                                                   v-model="edited_handle.price.dealer" required>
                                            <label :for="'edit-fast-new-handle-price-dealer-'+item.id">Цена дилера,
                                                руб</label>
                                        </div>
                                        <div class="form-floating">
                                            <input type="number" class="form-control"
                                                   :id="'edit-fast-new-handle-price-retail-'+item.id"
                                                   v-model="edited_handle.price.retail" required>
                                            <label :for="'edit-fast-new-handle-price-retail-'+item.id">Розничная цена,
                                                руб</label>
                                        </div>

                                        <div class="form-floating">
                                            <input type="number" class="form-control"
                                                   :id="'edit-fast-new-handle-price-cost-'+item.id"
                                                   v-model="edited_handle.price.cost" required>
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
                                            Удалить ручку

                                        </button>
                                    </div>

                                </form>

                            </template>
                        </div>
                    </div>


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
            edited_handle: null,
            success_added: [],
            filter_modal: null,
            new_handles: [],
            searchQuery: ''
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
        this.filter_modal = new bootstrap.Modal(document.getElementById('handlers-filter-modal'));
        this.door = this.modelValue


    },
    methods: {
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
        saveEditedHandle() {
            if (!this.edited_handle)
                return;

            this.edit_loading = true
            this.$store.dispatch("fastEditHandle", {
                handle: this.edited_handle
            }).then((response) => {
                this.$notify({
                    title: "DoDoors",
                    text: "Вы сохранили данные по ручке",
                });

                this.edit_loading = false
                this.edited_handle = null
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
        removeSelectedHandle() {
            if (!this.edited_handle)
                return;

            this.edit_loading = true
            this.$store.dispatch("removeHandle", {
                handleId: this.edited_handle.id
            }).then(() => {
                this.edit_loading = false
                this.reloadHandles()
            }).catch(() => {
                this.edit_loading = false
            })

        },
        showFilterModal() {
            this.edited_handle = null
            this.filter_modal.show()
        },
        selectHandle(handle) {
            let index = this.success_added.findIndex(item => item === handle.title)

            if (index != -1)
                this.success_added.splice(index, 1)

            this.door.handle_holes_type = handle.id == null ? {title: null} : handle

            localStorage.setItem("dodoors_handle_holes_type_selected", JSON.stringify(this.door.handle_holes_type))
            console.log("Save to ls", this.door.handle_holes_type)
            this.edited_handle = null;
            this.filter_modal.hide()
        },
        editHandle(handle) {

            if (this.edited_handle && this.edited_handle?.id === handle.id) {
                this.edited_handle = null
                return;
            }

            this.edited_handle = null
            this.$nextTick(() => {
                this.edited_handle = handle
            })
        },
        saveHandles() {

            this.$store.dispatch("fastStoreHandles", {
                handles: this.new_handles
            }).then((response) => {
                this.$notify({
                    title: "DoDoors",
                    text: "Вы сохранили данные по ручкам",
                });


                this.new_handles.forEach(item => {
                    this.success_added.push(item.title)
                    this.$store.dispatch("pushHandles", {
                        title: item.title,
                        price: item.price
                    })
                })

                this.new_handles = []
                this.$store.dispatch("updatedFormattedSizes").then(resp => {
                    window.dispatchEvent(new CustomEvent("load-sizes", {
                        detail: null
                    }));
                    this.$notify({
                        title: "DoDoors",
                        text: "Вы успешно обновили данные",
                    });
                })
            }).catch(error => {
                this.$notify({
                    title: "DoDoors",
                    text: "Ошибка сохранения ручек",
                    type: 'error'
                });
            })
        },
        removeHandle(index) {
            this.new_handles.splice(index, 1)
        },
        addNewHandle() {
            this.new_handles.push({
                title: '',
                price: 0,
            })
        },
        reset() {
            this.edited_handle = null
            this.filter_modal.hide()
            this.door.handle_holes_type = {title: null}
            this.searchQuery = ''
        }
    }
}
</script>
