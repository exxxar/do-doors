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
                        <input type="search" class="form-control" id="searchInput" placeholder="Поиск..." v-model="searchQuery">
                        <label for="searchInput">Поиск...</label>
                    </div>

                    <div class="list-group">
                        <div v-for="item in filteredItems" :key="item.title"
                             class="list-group-item cursor-pointer"
                             :class="{'list-group-item-primary': door.handle_holes_type === item}"
                             @click="door.handle_holes_type = item">
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
                item.title.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        }
    },
    mounted() {
        this.door = this.modelValue
    },
    methods:{
        reset(){
            this.door.handle_holes_type={title:null}
            this.searchQuery = ''
        }
    }
}
</script>
