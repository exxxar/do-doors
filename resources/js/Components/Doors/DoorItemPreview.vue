<script setup>
import DoorPreview from "@/Components/Doors/DoorPreview.vue";
import MaterialSelectForm from "@/Components/Doors/MaterialSelectForm.vue";
import ColorSelector from "@/Components/Calc/ColorSelector.vue";
</script>

<template>

    <template v-if="door">
        <div class="row">

            <div class="col-md-6">


                <div class="row">
                    <div class="col-md-6 col-12 mb-2">
                        <button
                            :disabled="!canEdit"
                            @click="editVariant"
                            type="button"
                            class="btn btn-dark rounded-0 w-100 p-3"><i class="fa-solid fa-floppy-disk"></i> Редактировать
                        </button>
                    </div>

                    <div class="col-md-6 col-12 mb-2">
                        <div class="card rounded-0 border-black">
                            <div class="card-body px-2 py-1">
                                <label class="font-size-10"><i class="fa-solid fa-signs-post"></i> Назначение
                                    двери</label>
                                <p>{{ door.purpose || 'Не указано' }}</p>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-12 mb-2">

                        <div class="card rounded-0 border-black">
                            <div class="card-body px-2 py-1">
                                <label class="font-size-10"><i class="fa-solid fa-ruler-vertical"></i> Высота,
                                    мм</label>
                                <p v-html="door.height"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 mb-2">
                        <div class="card rounded-0 border-black">
                            <div class="card-body px-2 py-1">
                                <label class="font-size-10"><i class="fa-solid fa-ruler-horizontal"></i> Ширина,
                                    мм
                                </label>
                                <p v-html="door.width"></p>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 col-12 mb-2">
                        <div class="card rounded-0 border-black">
                            <div class="card-body px-2 py-1">
                                <label class="font-size-10"> <i class="fa-brands fa-openid"></i> Тип открытия двери и
                                    толщина
                                </label>
                                <p>{{ door.opening_type.title || '-' }} (толщина
                                    {{ door.opening_type.depth }}
                                    мм)</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12 mb-2">

                        <div class="card rounded-0 border-black">
                            <div class="card-body px-2 py-1">
                                <label class="font-size-10"><i class="fa-solid fa-door-open"></i> Тип двери
                                </label>
                                <p>{{ door.door_type.title || '-' }}</p>
                            </div>
                        </div>

                    </div>


                    <div class="col-md-6 col-12 mb-2">

                        <div class="card rounded-0 border-black">
                            <div class="card-body px-2 py-1">
                                <label class="font-size-10"><i class="fa-solid fa-industry"></i> Производитель
                                    петель
                                </label>
                                <p>{{ door.hinge_manufacturer.title || '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12 mb-2">

                        <div class="card rounded-0 border-black">
                            <div class="card-body px-2 py-1">
                                <label class="font-size-10"><i class="fa-solid fa-angles-left"></i> Сторона петель
                                </label>
                                <p>{{ door.loops_variants?.title || '-' }}</p>
                            </div>
                        </div>

                    </div>


                    <div class="col-md-6 col-12  mb-2">

                        <div class="card rounded-0 border-black">
                            <div class="card-body px-2 py-1">
                                <label class="font-size-10"><i class="fa-solid fa-paint-roller"></i> Отделка первой
                                    стороны
                                </label>
                                <p>{{ door.front_side_finish?.title || '-' }}</p>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-12 mb-2">
                        <div
                            v-if="door.front_side_finish.title!=='Под покраску'"
                            v-bind:style="{'background-color':door.front_side_finish.code,'color':invertHex(door.front_side_finish.code)}"
                            class="card rounded-0 border-black">
                            <div class="card-body px-2 py-1">
                                <label class="font-size-10"><i class="fa-solid fa-palette"></i> Цвет отделки первой
                                    стороны
                                </label>
                                <p>{{ door.front_side_finish.title || '-' }}</p>
                            </div>
                        </div>
                        <div class="card rounded-0" v-else>
                            <div class="card-body p-3 disabled-element">
                                <p class="text-center">Выбрано "Под покраску"</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12 mb-2">

                        <div class="card rounded-0 border-black">
                            <div class="card-body px-2 py-1">
                                <label class="font-size-10"><i class="fa-solid fa-paint-roller"></i> Отделка второй
                                    стороны
                                </label>
                                <p>{{ door.back_side_finish.title || '-' }}</p>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6 col-12 mb-2">

                        <div
                            v-if="door.back_side_finish.title!=='Под покраску'"
                            v-bind:style="{'background-color':door.back_side_finish.code,'color':invertHex(door.back_side_finish.code)}"
                            class="card rounded-0 border-black">
                            <div class="card-body px-2 py-1">
                                <label class="font-size-10"><i class="fa-solid fa-palette"></i> Цвет отделки второй
                                    стороны
                                </label>
                                <p>{{ door.back_side_finish.title || '-' }}</p>
                            </div>
                        </div>
                        <div class="card rounded-0" v-else>
                            <div class="card-body p-3 disabled-element">
                                <p class="text-center">Выбрано "Под покраску"</p>
                            </div>
                        </div>

                    </div>


                    <div class="col-md-6 col-12 mb-2">


                        <div
                            v-bind:style="{'background-color':door.box_and_frame_color.code,'color':invertHex(door.box_and_frame_color.code)}"
                            class="card rounded-0 border-black">
                            <div class="card-body px-2 py-1">
                                <label class="font-size-10"><i class="fa-solid fa-palette"></i> Цвет короба и каркаса
                                </label>
                                <p>{{ door.box_and_frame_color.title || '-' }}</p>
                            </div>
                        </div>


                    </div>

                    <div class="col-md-6 col-12 mb-2">

                        <div
                            v-bind:style="{'background-color':door.seal_color.code,'color':invertHex(door.seal_color.code)}"
                            class="card rounded-0 border-black">
                            <div class="card-body px-2 py-1">
                                <label class="font-size-10"><i class="fa-solid fa-palette"></i> Цвет уплотнителя
                                </label>
                                <p>{{ door.seal_color.title || '-' }}</p>
                            </div>
                        </div>


                    </div>

                    <div class="col-md-6 col-12 mb-2">

                        <div
                            v-bind:style="{'background-color':door.fittings_color.code,'color':invertHex(door.fittings_color.code)}"
                            class="card rounded-0 border-black">
                            <div class="card-body px-2 py-1">
                                <label class="font-size-10"><i class="fa-solid fa-palette"></i> Цвет фурнитуры
                                </label>
                                <p>{{ door.fittings_color.title || '-' }}</p>
                            </div>
                        </div>


                    </div>

                    <div class="col-md-6 col-12 mb-2"
                         v-if="door.fittings_color.title!=null&&door.fittings_color.is_ral">

                        <div
                            v-bind:style="{'background-color':door.service_painting.code,'color':invertHex(door.service_painting.code)}"
                            class="card rounded-0 border-black">
                            <div class="card-body px-2 py-1">
                                <label class="font-size-10"><i class="fa-solid fa-palette"></i> Цвет фурнитуры
                                </label>
                                <p>{{ door.service_painting.title || '-' }}</p>
                            </div>
                        </div>


                    </div>


                    <div class="col-12 mb-2">

                        <div
                            style="min-height: 100px;"
                            class="card rounded-0 border-black">
                            <div class="card-body px-2 py-1">
                                <label class="font-size-10">Комментарий к двери
                                </label>
                                <p>{{ door.comment || '-' }}</p>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="row py-3" v-if="need_addition">

                    <div class="col-12 d-flex align-items-center">

                        <p>
                            Ручка:
                            <span class="fw-bold" v-if="door.need_handle_holes">нужна</span>
                            <span class="fw-bold" v-else>не нужна</span>
                        </p>


                    </div>

                    <div class="col-md-6 col-12 mb-2" v-if="door.need_handle_holes">

                        <div
                            class="card rounded-0 border-black">
                            <div class="card-body px-2 py-1">
                                <label class="font-size-10">Отверстие под ручку
                                </label>
                                <p>{{ door.handle_holes_variants?.title || '-' }}</p>
                            </div>
                        </div>


                    </div>

                    <div class="col-md-6 col-12 mb-2" v-if="door.need_handle_holes&&door.handle_holes.id!==3">

                        <div
                            class="card rounded-0 border-black">
                            <div class="card-body px-2 py-1">
                                <label class="font-size-10">Вариант ручки
                                </label>
                                <p>{{ door.handle_holes_type.title || '-' }}</p>
                            </div>
                        </div>

                    </div>

                    <div
                        v-if="door.need_handle_holes&&door.handle_holes.id!==3"
                        class="col-12 mb-2">


                        <div
                            class="card rounded-0 border-black">
                            <div class="card-body px-2 py-1">
                                <label class="font-size-10">Вариант дополнительного сервиса
                                </label>
                                <p>{{ door.service_handle?.title || '-' }}</p>
                            </div>
                        </div>


                    </div>

                    <div class="col-12"
                         v-if="(door.handle_holes_type.variants||[]).length>0&&door.need_handle_holes&&door.handle_holes.id!==3">
                        <div class="row">

                            <div class="col-12">
                                <p class="mb-2">Цвет ручки {{ door.handle_holes_type.color || 'не указан' }}
                                    <span
                                        class="d-inline-block"
                                        v-bind:style="{'background-color': door.handle_holes_type.color }"
                                        style="width:50px; height: 10px;"
                                        v-if="door.handle_holes_type.color"
                                    >
                        </span>
                                </p>

                            </div>
                            <div class="col-lg-3 col-md-3 col-12 mb-2"
                                 v-for="(item, index) in door.handle_holes_type.variants">
                                <div class="card cursor-pointer"
                                     v-bind:class="{'border-secondary shadow-lg':item.selected}"
                                     @click="selectSideFinish('handle_holes_type','variants',index)">
                                    <img v-lazy="item.image" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h6 class="font-bold" v-if="item.title">{{ item.title || 'не указано' }}</h6>
                                        <p class="card-text" v-if="item.description">{{
                                                item.description || 'не указано'
                                            }}</p>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-12"
                         v-if="(door.handle_holes_type.variants||[]).length===0&&door.need_handle_holes">

                        <div class="alert alert-warning rounded-0" role="alert">
                            <p>Вариантов изображений ручки нет</p>
                        </div>
                    </div>

                    <div class="col-12 d-flex align-items-center">

                        <p>
                            Верхняя перемычка:
                            <span class="fw-bold" v-if="door.need_upper_jumper">нужна</span>
                            <span class="fw-bold" v-else>не нужна</span>
                        </p>


                    </div>


                    <div class="col-12 d-flex align-items-center">


                        <p>
                            Автоматический порог:
                            <span class="fw-bold" v-if="door.need_upper_jumper">нужен</span>
                            <span class="fw-bold" v-else>не нужен</span>
                        </p>


                    </div>


                    <div
                        v-if="door.need_automatic_doorstep"
                        class="col-12">

                        <div
                            class="card rounded-0 border-black">
                            <div class="card-body px-2 py-1">
                                <label class="font-size-10">Вариант
                                </label>
                                <p>{{ door.service_doorstep?.title || '-' }}</p>
                            </div>
                        </div>




                    </div>

                    <div class="col-12 d-flex align-items-center">

                        <p>
                            Скрытый стопор:
                            <span class="fw-bold" v-if="door.need_hidden_stopper">нужен</span>
                            <span class="fw-bold" v-else>не нужен</span>
                        </p>


                    </div>


                    <div
                        v-if="door.need_hidden_stopper"
                        class="col-12">

                        <div
                            class="card rounded-0 border-black">
                            <div class="card-body px-2 py-1">
                                <label class="font-size-10">Вариант
                                </label>
                                <p>{{ door.service_stopper?.title || '-' }}</p>
                            </div>
                        </div>


                    </div>


                    <div class="col-12 d-flex align-items-center">

                        <p>
                            Скрытый доводчик:
                            <span class="fw-bold" v-if="door.need_hidden_door_closer">нужен</span>
                            <span class="fw-bold" v-else>не нужен</span>
                        </p>


                    </div>

                    <div
                        v-if="door.need_hidden_door_closer"
                        class="col-12 ">

                        <div
                            class="card rounded-0 border-black">
                            <div class="card-body px-2 py-1">
                                <label class="font-size-10">Вариант
                                </label>
                                <p>{{ door.service_door_closer?.title || '-' }}</p>
                            </div>
                        </div>


                    </div>

                    <div class="col-12 d-flex align-items-center">

                        <p>
                            Скрытый плинтус:
                            <span class="fw-bold" v-if="door.need_hidden_skirting_board">нужен</span>
                            <span class="fw-bold" v-else>не нужен</span>
                        </p>


                    </div>


                    <div class="col-12 d-flex align-items-center">

                        <p>
                            Установка двери:
                            <span class="fw-bold" v-if="door.need_door_install">нужна</span>
                            <span class="fw-bold" v-else>не нужна</span>
                        </p>


                    </div>


                    <div class="col-12 d-flex align-items-center">

                        <p>
                            Упаковка двери:
                            <span class="fw-bold" v-if="door.need_wrapper">нужна</span>
                            <span class="fw-bold" v-else>не нужна</span>
                        </p>


                    </div>

                </div>


            </div>
            <div class="col-md-6">
                <div class="preview">
                    <DoorPreview
                        :disabled="true"
                        v-if="loadedParams"
                        v-model="door">
                    </DoorPreview>
                    <div class="card rounded-0 mt-3">
                        <div class="card-body">
                            <h6>Характеристики</h6>

                            <h6 class="text-muted font-bold">{{ door.door_type.title }} {{
                                    door.width
                                }}x{{ door.height }}x{{ door.opening_type?.depth || 0 }}
                            </h6>
                            <h6 class="text-black mb-0">

                                            <span class="mr-1"
                                                  v-if="door.box_and_frame_color.title">({{
                                                    door.box_and_frame_color.title
                                                }}),</span>

                                <span
                                    class="mr-1"
                                    v-if="door.front_side_finish.title">первая сторона {{
                                        door.front_side_finish.title
                                    }}, </span>
                                <span
                                    class="mr-1"
                                    v-if="door.back_side_finish.title">/вторая сторона {{
                                        door.back_side_finish.title
                                    }},</span>
                                <span
                                    class="mr-1"
                                    v-if="door.loops.title">петли {{ door.loops.title }}</span>
                                <span
                                    class="mr-1"
                                    v-if="door.hinge_manufacturer.title ">{{
                                        door.hinge_manufacturer.title
                                    }}</span>
                                <span
                                    class="mr-1"
                                    v-if="door.fittings_color.title">({{
                                        door.fittings_color.title
                                    }}),</span>
                                <span
                                    class="mr-1"
                                    v-if="door.opening_type.title">{{
                                        door.opening_type.title
                                    }},</span>
                                <span
                                    class="mr-1"
                                    v-if="door.handle_holes.title">{{
                                        door.handle_holes.title
                                    }}</span>
                            </h6>
                            <div class="row row-cols-md-2 mt-3">
                                <div class="col mb-2">
                                    <div
                                        class="card rounded-0 border-black">
                                        <div class="card-body px-2 py-1">
                                            <label class="font-size-10">Тип цены
                                            </label>
                                            <p>{{ door.price_type.title || '-' }}</p>
                                        </div>
                                    </div>


                                </div>
                                <div class="col mb-2"
                                     v-if="door.price_type.id===3">


                                    <div
                                        class="card rounded-0 border-black">
                                        <div class="card-body px-2 py-1">
                                            <label class="font-size-10">Процент дилера
                                            </label>
                                            <p>{{ door.dealer_percent || '0' }}</p>
                                        </div>
                                    </div>


                                </div>
                                <div class="col mb-2">
                                    <div
                                        class="card rounded-0 border-black">
                                        <div class="card-body px-2 py-1">
                                            <label class="font-size-10">Кол-во
                                            </label>
                                            <p>{{ door.count || '0' }}</p>
                                        </div>
                                    </div>


                                </div>
                                <div class="col mb-2">

                                    <div
                                        class="card rounded-0 border-black">
                                        <div class="card-body px-2 py-1">
                                            <label class="font-size-10">Цена
                                            </label>
                                            <p>{{ door.price }} ₽</p>
                                        </div>
                                    </div>


                                </div>
                                <div
                                    v-if="canEdit"
                                    class="col d-flex mb-2">
                                    <button
                                        @click="editVariant"
                                        type="button"
                                        class="btn btn-dark rounded-0 w-100"><i class="fa-solid fa-floppy-disk"></i> Редактировать
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card rounded-0 mt-3" v-if="tmp_prices.length>0">
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                                <tr v-for="item in tmp_prices">
                                    <td>{{ type_dictionary[item.type] || item.type }}
                                        <template v-if="door[item.type]">
                                            <br>
                                            <small
                                                v-if="door[item.type].description">({{
                                                    door[item.type].description
                                                }})</small>
                                        </template>
                                    </td>
                                    <td>{{ item.price || 0 }} руб.
                                        <template v-if="item.full_price">
                                            <br>
                                            <small>({{ item.full_price || 0 }} руб.)</small>
                                        </template>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>



    </template>
    <div class="row" v-else>
        <div class="col-12">
            <div class="d-flex justify-content-center align-items-center flex-column" style="min-height: 500px;">
                <h5>Загружаем страничку....</h5>
                <div class="spinner-border my-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>


</template>
<script>
import {mapGetters} from "vuex";
import {uuid} from 'vue-uuid';


export default {

    name: 'MyComponent',
    props: ['modelValue','canEdit'],
    data() {
        return {
            loaded: false,
            door: null,
            type_dictionary: {
                size: 'Петли',
                handle_holes_type: 'Отверстие под ручку',
                opening_type: 'Тип открытия двери и толщина',
                box_and_frame_color: 'Цвет короба и каркаса',
                door_type: 'Тип двери',
                front_side_finish_color: 'Цвет отделки внешней стороны',
                back_side_finish_color: 'Цвет отделки внутренней стороны',
                seal_color: 'Цвет уплотнителя',
                fittings_color: 'Цвет фурнитуры',
                hinge_manufacturer: 'Производитель петель',
                front_side_finish: 'Отделка внешней стороны',
                back_side_finish: 'Отделка внутренней стороны',
                base: 'База (под покраску)',
                service_doorstep: 'Работа с порогом',
                service_painting: 'Покраска фурнитуры',
                service_door_closer: 'Работа с доводчиком',
                service_handle: 'Работа с ручками',
                service_stopper: 'Работа со стопором',

            },
            tmp_prices: [],
            need_addition: true,
            messages: [],
            filterHeight: null,
            filterWidth: null,
            selectedColorParam: null,
            loadedParams: true,
            confirmModal: null,
            finishFrontVariantModal: null,
            finishBackVariantModal: null,

            colors: [],
            confirm: {
                title: null,
                message: null,
            },
            color_sync_update: false,
        }
    },
    computed: {
        ...mapGetters(['getErrors', 'getDictionary', 'cartTotalCount', 'cartProducts', 'cartTotalPrice']),

    },
    watch: {
        'door': {
            handler(val) {
                this.$emit('update:modelValue', this.door)
            },
            deep: true
        }
    },

    mounted() {
        this.door = this.modelValue
    },
    methods: {
        editVariant(){
          this.$emit("edit")
        },

        invertHex(color) {
            if (!color)
                return "#000000";

            var hex = color.replace(/#/, '');
            var red = parseInt(hex.substr(0, 2), 16);
            var green = parseInt(hex.substr(2, 2), 16);
            var blue = parseInt(hex.substr(4, 2), 16);

            var luminance = (0.2126 * red + 0.7152 * green + 0.0722 * blue) / 255;
            return luminance > 0.5 ? '#000000' : '#ffffff';
        },
    }
}
</script>


<style lang="scss">


.fixed-price {
    position: fixed;
    bottom: 101px;
    right: 30px;
    padding: 5px;
    z-index: 10;
    box-sizing: border-box;
    font-weight: 800;
    background-color: white;
    min-width: 89px;


    &:hover {

        span {
            color: white !important;
        }


    }


    @media (max-width: 767.98px) {
        width: 100%;
        bottom: 50px;
        right: 0px;
        display: none;

    }

}


.scrollable-menu {
    height: 200px;
    overflow-y: auto;
}

.footer-nav {
    position: fixed;
    bottom: 10px;
    margin: 0;
    /* background: red; */
    z-index: 1000;
    left: 0;
    padding: 20px;
    box-sizing: border-box;
}

.disabled-element {
    background-image: repeating-linear-gradient(-45deg, #eeeeee 0, #eeeeee 15px, #ffffff 15px, #ffffff 25px);
}
</style>
