<template>
    <div
        data-bs-toggle="modal" data-bs-target="#handlers-filter-modal"
        class="card rounded-0 border-black cursor-pointer">
        <div class="card-body px-2 py-1">

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
                        <div v-for="item in filteredItems" :key="item.title"
                             class="list-group-item cursor-pointer"
                             :class="{'list-group-item-primary': door.handle_holes_type === item,
                             'list-group-item-success':success_added.indexOf(item.title)!=-1&&item.id!=null,
                             'list-group-item-warning':success_added.indexOf(item.title)!=-1&&item.id==null,

                             }"
                             @click="selectHandle(item)">
                            {{ item.title }}
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
            success_added: [],
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
        ...mapGetters(['getDictionary',]),
        filteredItems() {
            return this.getDictionary.handle_holes_type_variants.filter(item =>
                (item.title) ? item.title.toLowerCase().includes(this.searchQuery.toLowerCase()) : ''
            ).reverse();
        }
    },
    mounted() {
        this.door = this.modelValue
    },
    methods: {
        selectHandle(handle) {
            let index = this.success_added.findIndex(item => item === handle.title)

            if (index != -1)
                this.success_added.splice(index, 1)

            this.door.handle_holes_type = handle.id == null ? {title: null} : handle
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
            this.door.handle_holes_type = {title: null}
            this.searchQuery = ''
        }
    }
}
</script>
