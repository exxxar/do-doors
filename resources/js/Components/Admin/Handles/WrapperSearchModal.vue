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

    },
    mounted() {
        this.filter_modal = new bootstrap.Modal(document.getElementById('wrapper-filter-modal'));
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
