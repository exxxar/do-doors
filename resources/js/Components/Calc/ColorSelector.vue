<script setup>
import RalColorSelector from "@/Components/Support/RalColorSelector.vue";
</script>

<template>

    <div v-if="color" class="mb-2">
        <div
            class="dropdown-center"
            v-if="(color.code||null)!=='RAL'">
            <button
                v-bind:class="{'text-white':color.code||null}"
                v-bind:style="{'background-color':color.code}"
                class="btn btn-outline-secondary w-100 rounded-0 custom-dropdown-btn text-left"
                type="button"
                data-bs-toggle="dropdown"
                data-bs-auto-close="true"
                aria-expanded="false">
                <span
                      v-bind:class="{'font-size-10':color.title}"
                      class="mr-2"><i class="fa-solid fa-palette"></i> <slot name="name"></slot></span>
                <p class="mb-0" v-if="color.title"> {{ color.title }}</p>
            </button>
            <ul class="dropdown-menu rounded-0">
                <li><a class="dropdown-item" href="javascript:void(0)"
                       @click="selectColor(null)">Не выбрано</a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item"
                       v-bind:class="{'bg-primary text-white':color.title===item.title }"
                       @click="selectColor(item)"
                       href="javascript:void(0)" v-for="item in filteredColors">{{ item.title }}</a>
                </li>
            </ul>
        </div>

        <div
            v-if="(color.code||null)==='RAL'"
            class="input-group mb-3">
                      <span class="input-group-text border-secondary"
                            v-if="isHex(color.title)"
                            v-bind:style="{'background-color':color.title}"
                            id="basic-addon1" style="width: 40px;border-radius: 0px;">
                   </span>
            <div class="form-floating">
                <input type="text"
                       @invalid="alert('Вы не выбрали цвет')"
                       v-model="color.title"
                       class="form-control" id="seal_color" required>
                <label for="seal_color"><i class="fa-solid fa-palette"></i>
                    <slot name="name"></slot>
                </label>
            </div>
            <button class="btn btn-outline-secondary" type="button"
                    data-bs-auto-close="true"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end rounded-0">
                <li><a class="dropdown-item" href="javascript:void(0)"
                       @click="color = {title:null}">Не выбрано</a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item"
                       v-bind:class="{'bg-primary text-white':color.title===item.title }"
                       @click="selectColor(item)"
                       href="javascript:void(0)" v-for="item in filteredColors">{{ item.title }}</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" :id="'select-ral-color-'+id" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Выбор цвета RAL</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <RalColorSelector v-on:select="callbackSelectColor"></RalColorSelector>

                </div>

            </div>
        </div>
    </div>

</template>
<script>
import {mapGetters} from "vuex";
import {uuid} from "vue-uuid";

export default {
    props: ["modelValue"],
    data() {
        return {
            id: null,
            color: null,
            colorModal: null,
            colors: [],
        }
    },
    watch: {
        'getRalColors': {
            handler(val) {
                this.colors = this.getRalColors
            },
            deep: true,
        },
        'color': {
            handler(val) {
                let search = this.color.title

                if ((this.color.title || '').length === 4) {
                    Object.keys(this.colors).forEach(key => {
                        if (this.colors[key].code === search) {
                            this.color.code = this.colors[key].color.hex
                            this.color.title = this.colors[key].names.en
                        }

                    })
                }

            },
            deep: true
        },
    },
    computed: {
        ...mapGetters(['getDictionary','getRalColors']),

        filteredColors() {
            let colors = this.getDictionary.color_variants
            return colors.filter(item => item.type === "seal" || item.type === "all")
        },
    },
    mounted() {

        this.id = uuid.v4();
        this.color = this.modelValue

    },
    methods: {

        isHex(num) {
            return /^#[0-9A-F]{6}$/i.test(num)
        },
        alert(message) {
            this.$emit("invalid", message)
        },
        callbackSelectColor(item) {

            this.color.title = item.names.en
            this.color.code = item.color.hex

            this.colorModal.hide()
        },
        selectColor(item) {
            let color = null

            if (item != null) {
                color = {
                    title: item.title || item.code,
                    code: item.code || null,
                    sizes: item.sizes,
                    type: item.type || 'all',
                    assign_with_size: item.assign_with_size || false,
                }

                if (item.title === "RAL") {
                    color = {
                        title: 'RAL',
                        code: 'RAL',
                        sizes: item.sizes,
                        type: item.type || 'all',
                        assign_with_size: item.assign_with_size || false,
                    }

                    this.colorModal = new bootstrap.Modal(document.getElementById('select-ral-color-' + this.id), {})
                    this.colorModal.show()
                }
            }

            this.color = color || {title: null}
            const dropdownElementList = document.querySelectorAll('.dropdown-menu')
            dropdownElementList.forEach(el => {
                el.classList.remove("show")
            })

            this.$emit("change", this.color)
            this.$emit("update:modelValue", this.color)
        }
    }
}
</script>
<style>

.font-size-10 {
    font-size:10px;
}
.custom-dropdown-btn {
    height: 58px;
    min-height:  58px;

}


</style>
