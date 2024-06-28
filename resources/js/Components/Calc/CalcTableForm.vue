<script setup>
import DoorTableItemEditor from "@/Components/Doors/DoorTableItemEditor.vue";
</script>
<template>
    <div class="row">
        <div class="col-md-4">
            <table class="table table-striped">
                <thead>
                <th>Номер двери</th>
                </thead>
                <tbody>
                <tr>
                    <td>Стоимость за единицу</td>
                </tr>

                <tr>
                    <td>Итого за 1 двери</td>
                </tr>

                <tr>
                    <td>Тип двери</td>
                </tr>

                <tr>
                    <td>Размер двери по прайсу</td>
                </tr>

                <tr>
                    <td>высота</td>
                </tr>


                <tr>
                    <td>ширина</td>
                </tr>


                <tr>
                    <td>Количество дверей</td>
                </tr>

                <tr>
                    <td>открывание</td>
                </tr>

                <tr>
                    <td>Отделка с передней стороны</td>
                </tr>

                <tr>
                    <td>укажите RAL</td>
                </tr>


                <tr>
                    <td>Отделка с задней стороны</td>
                </tr>

                <tr>
                    <td>укажите RAL</td>
                </tr>

                <tr>
                    <td>Цвет фурнитуры</td>
                </tr>

                <tr>
                    <td>петли</td>
                </tr>

                <tr>
                    <td>Верхняя перемычка</td>
                </tr>

                <tr>
                    <td>Растояние без верх перемычки: от верха двери до потолка (стандарт 5мм)</td>
                </tr>

                <tr>
                    <td>Производитель петель</td>
                </tr>

                <tr>
                    <td>Отверстий под ручку (тип ручки влияет)</td>
                </tr>

                <tr>
                    <td>Автоматический порог</td>
                </tr>

                <tr>
                    <td>Скрытый стопор</td>
                </tr>

                <tr>
                    <td>Скрытый доводчик</td>
                </tr>

                <tr>
                    <td>Тип цены</td>
                </tr>

                <tr>
                    <td>Дополнительно добавить к цене за дверь</td>
                </tr>


                </tbody>
            </table>
        </div>
        <div class="col-md-8">
            <div class="overflow">
                <DoorTableItemEditor></DoorTableItemEditor>
                <DoorTableItemEditor :door="item" v-for="item in cartProducts"></DoorTableItemEditor>
            </div>

        </div>
    </div>
</template>
<script>
import {mapGetters} from "vuex";



export default {

    name: 'MyComponent',

    data() {
        return {
            need_addition: true,
            messages: [],
            filterHeight: null,
            filterWidth: null,
            selectedColorParam: null,
            colorModal: null,
            confirmModal: null,
            finishFrontVariantModal: null,
            finishBackVariantModal: null,

            colors: [],
            confirm: {
                title: null,
                message: null,
            },
            doorForm: {
                id: null,
                width: 0,
                height: 0,
                depth: 0,
                count: 1,
                price: 0,
                size: null,
                purpose: null,
                comment: null,
                dealer_percent: 0,
                opening_type: {title: null},
                box_and_frame_color: {title: null},
                door_type: {title: null},
                front_side_finish: {title: null},
                back_side_finish: {title: null},
                front_side_finish_color: {title: null},
                back_side_finish_color: {title: null},
                seal_color: {title: null},
                fittings_color: {title: null},
                loops: {title: null}, //расположение петель
                loops_count: 0,
                price_type: {title: null}, //Тип цены
                hinge_manufacturer: {title: null}, //Производитель петель
                handle_holes: {title: null}, //отверстие для ручек
                handle_holes_type: {title: null}, //тип ручки
                need_handle_holes: true, //нужна дверная ручка
                need_upper_jumper: false, //Верхняя перемычка
                need_automatic_doorstep: false, //Автоматический порог
                need_hidden_stopper: false, //Скрытый стопор
                need_hidden_door_closer: false, //Скрытый доводчик
                need_hidden_skirting_board: false, //нужен плинтус
                need_door_install: false, //нужна установка двери
                need_wrapper: false //нужна упаковка двери
            }
        }
    },
    computed: {
        ...mapGetters([ 'getDictionary', 'cartTotalCount', 'cartProducts', 'cartTotalPrice']),

    },

    mounted() {

    },
    methods: {

    }
}
</script>
<style lang="scss">
.overflow {
    width: 100%;
    padding: 12px 0px;
    overflow-x: scroll;
    display: flex;
}
th,
td {
    height: 50px;
}
</style>
