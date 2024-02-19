<template>
    <div class="row">
        <div class="col-12">
            <button class="btn btn-outline-success rounded-5 my-2">Добавить новую дверь</button>
        </div>
        <div class="col-md-6 col-12">
            <div class="input-group mb-3">
                <div class="form-floating">
                    <input type="number"
                           min="0"
                           v-model="doorForm.height"
                           class="form-control" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">Высота, мм</label>
                </div>
                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Separated link</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="input-group mb-3">

                <div class="form-floating">
                    <input type="number"
                           min="0"
                           v-model="doorForm.width"
                           class="form-control" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">Ширина, мм</label>
                </div>
                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Separated link</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="form-floating mb-3">
                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                <label for="floatingSelect">Толщина двери</label>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="form-floating mb-3">
                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                <label for="floatingSelect">Сторона петель</label>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="form-floating mb-3">
                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                <label for="floatingSelect">Отделка первой стороны (<small>вровень со стеной</small>)</label>
            </div>

        </div>

        <div class="col-md-6 col-12">
            <div class="form-floating mb-3">
                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                <label for="floatingSelect">Отделка второй стороны</label>
            </div>
        </div>
        <div class="col-12">
            <div class="form-check form-switch">
                <input class="form-check-input"
                       type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                <label class="form-check-label" for="flexSwitchCheckChecked">
                    Нужна ручка \ не нужна ручка
                </label>
            </div>
        </div>
        <div class="col-12">
            <div class="form-check form-switch">
                <input class="form-check-input"
                       type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                <label class="form-check-label" for="flexSwitchCheckChecked">
                    Нужен автоматический порог \ не нужен
                </label>
            </div>
        </div>

        <div class="col-12">
            <div class="form-check form-switch">
                <input class="form-check-input"
                       type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                <label class="form-check-label" for="flexSwitchCheckChecked">
                    Нужен скрытый стопор \ не нужен
                </label>
            </div>
        </div>

        <div class="col-12">
            <div class="form-check form-switch">
                <input class="form-check-input"
                       type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                <label class="form-check-label" for="flexSwitchCheckChecked">
                    Нужен скрытый доводчик \ не нужен
                </label>
            </div>
        </div>

        <div class="col-12">
            <div class="form-check form-switch">
                <input class="form-check-input"
                       type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                <label class="form-check-label" for="flexSwitchCheckChecked">
                    Нужен скрытый плинтус \ не нужен
                </label>
            </div>
        </div>

        <div class="col-12">
            <div class="form-check form-switch">
                <input class="form-check-input"
                       type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                <label class="form-check-label" for="flexSwitchCheckChecked">
                    Нужен установка двери \ не нужна
                </label>
            </div>
        </div>

        <div class="col-12 ">
            <p class="mr-2 text-center mb-2 font-bold">Количество дверей с такой отделкой</p>
            <div class="row d-flex justify-content-center flex-wrap flex-col align-items-center">
                <div class="col-md-4 col-12 ">
                    <div class="card w-100" >
                        <div class="card-body d-flex justify-content-between">
                            <div class="p-2">
                                <button type="button" class="btn btn-outline-danger">
                                    <i class="fa-solid fa-minus"></i>
                                </button>

                            </div>
                            <div class="input-group p-2">
                                <input type="number" min="1" value="1" class="form-control rounded-2 text-center">
                            </div>
                           <div class="p-2">
                               <button type="button" class="btn btn-outline-success">
                                   <i class="fa-solid fa-plus"></i>
                               </button>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <p class="font-bold">Внешний вид</p>
            <carousel v-bind="settings" class="p-2">
                <slide v-for="slide in 2" :key="slide">
                    <div class="p-1 door-image">
                        <img src="/images/door-1.jpg" class="img-thumbnail" alt="...">
                    </div>
                </slide>

                <template #addons>
                    <navigation />
                </template>
            </carousel>
        </div>

        <div class="col-md-6 col-12">
            <div class="card my-3">
                <div class="card-body">
                    <h6 class="font-bold my-2">Итого</h6>

                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Характеристики </td>
                            <td>  Комплект 2200х800х57 (черный) лицо зеркало /зеркало петли L стандарт 5 шт (черный), НА СЕБЯ , отв. под ручку</td>
                        </tr>
                        <tr>
                            <td>Цена </td>
                            <td><strong>30000 ₽</strong></td>
                        </tr>
                        </tbody>
                    </table>


                    <div class="row d-flex justify-content-center">
                        <div class="col-md-6 col-12">
                            <button class="btn btn-outline-success rounded-5 w-100">Добавить в корзину</button>
                        </div>
                    </div>



                </div>
            </div>
        </div>


    </div>
</template>
<script>
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'

export default {
    name: 'MyComponent',
    components: {
        Carousel,
        Slide,
        Pagination,
        Navigation, },
    data() {
        return {
            settings: {
                itemsToShow: 3,
                snapAlign: 'left',
            },

            opening_variants: [],
            door_variants: [],
            finishes_variants: [], //варианты отделки
            loops_variants: [], //петли
            size_variants: [], //варианты размеров
            color_variants: [], //варианты цветов
            handle_holes_variants: [], //отверстие под ручку
            hinge_manufacturer_variants: [], //производитель петель
            price_type_variants: [], //типы цен
            doorForm: {
                width: 0,
                height: 0,
                depth: 0,
                count: 0,
                opening_type: null,
                box_and_frame_color: null,
                door_type: null,
                front_side_finish: null,
                back_side_finish: null,
                front_side_finish_color: null,
                back_side_finish_color: null,
                seal_color: null,
                fittings_color: null,
                loops: null, //расположение петель
                price_type: null, //Тип цены
                hinge_manufacturer: null, //Производитель петель
                handle_holes: null, //отверстие для ручек
                need_upper_jumper: false, //Верхняя перемычка
                need_automatic_doorstep: false, //Автоматический порог
                need_hidden_stopper: false, //Скрытый стопор
                need_hidden_door_closer: false, //Скрытый доводчик

                need_door_install: false //нужна установка двери
            }
        }
    }
}
</script>
<style lang="scss">
.door-image {
    max-width: 200px;
    img {
        object-fit: cover;
    }
}
</style>
