<script setup>
import RalColorSelector from "@/Components/Support/RalColorSelector.vue";
import DoorPreview from "@/Components/Doors/DoorPreview.vue";
import MaterialSelectForm from "@/Components/Doors/MaterialSelectForm.vue";
</script>

<template>
    <form
        v-on:submit.prevent="submitForm"
        class="row">

        <div class="col-md-6 col-12">
            <div class="input-group mb-3">
                <div class="form-floating">
                    <input type="text"
                           min="0"
                           v-model="doorForm.purpose"
                           class="form-control" id="floatingInput">
                    <label for="floatingInput"><i class="fa-solid fa-signs-post"></i> Назначение двери</label>
                </div>
                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item"
                           @click="doorForm.purpose = null"
                           href="#">Не выбрано</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item"
                           @click="doorForm.purpose = item"
                           v-bind:class="{'bg-primary text-white':doorForm.purpose===item}"
                           href="#" v-for="item in getDictionary.purpose_variants">{{ item }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="form-floating mb-3">
                <select class="form-select"
                        v-model="doorForm.door_type"
                        @invalid="alert('Вы не выбрали тип двери!')"
                        id="door-type" aria-label="door-type" required>
                    <option :value="{title:null}">Выберите один из вариантов</option>
                    <option :value="item" v-for="item in getDictionary.door_variants">{{ item.title }}</option>
                </select>
                <label for="door-type"><i class="fa-solid fa-door-open"></i> Выберите тип двери</label>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="form-floating mb-3">
                <select class="form-select"
                        v-model="doorForm.hinge_manufacturer"
                        @invalid="alert('Вы не выбрали расположение петель!')"
                        id="floatingSelect" aria-label="Floating label select example" required>
                    <option :value="{title:null}">Выберите один из вариантов</option>
                    <option :value="item" v-for="item in getDictionary.hinge_manufacturer_variants">{{
                            item.title
                        }}
                    </option>
                </select>
                <label for="floatingSelect"><i class="fa-solid fa-industry"></i> Производитель петель</label>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="input-group mb-3">
                <div class="form-floating">
                    <input type="number"
                           min="0"
                           @invalid="alert('Вы не выбрали \ ввели высоту двери!')"
                           v-model="doorForm.height"
                           class="form-control" id="floatingInput" required>
                    <label for="floatingInput"><i class="fa-solid fa-ruler-vertical"></i> Высота, мм</label>
                </div>
                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="javascript:void(0)" @click="selectDoorSize(null)">Не выбрано</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="scrollable-menu p-2">
                        <div class="form-floating mb-3">
                            <input type="search"
                                   v-model="filterHeight"
                                   class="form-control" id="filtered-height" placeholder="name@example.com">
                            <label for="filtered-height">Фильтр высоты</label>
                        </div>
                        <a class="dropdown-item"
                           @click="selectDoorSize(item)"
                           v-bind:class="{'bg-primary':doorForm.width===item.width&&doorForm.width===item.height}"
                           href="#" v-for="item in filteredHeight">


                            {{ item.height }}x{{ item.width }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-6 col-12 mt-2">
            <div class="input-group mb-3">

                <div class="form-floating">
                    <input type="number"
                           min="0"
                           @invalid="alert('Вы не выбрали \ ввели ширину двери!')"
                           v-model="doorForm.width"
                           class="form-control" id="floatingInput" required>
                    <label for="floatingInput"><i class="fa-solid fa-ruler-horizontal"></i> Ширина, мм</label>
                </div>
                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="javascript:void(0)" @click="selectDoorSize(null)">Не выбрано</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="scrollable-menu p-2">
                        <div class="form-floating mb-3">
                            <input type="search"
                                   v-model="filterWidth"
                                   class="form-control" id="filtered-height" placeholder="name@example.com">
                            <label for="filtered-height">Фильтр ширины</label>
                        </div>

                        <a class="dropdown-item"
                           @click="selectDoorSize(item)"
                           v-bind:class="{'bg-primary text-white':doorForm.width===item.width&&doorForm.width===item.height}"
                           href="#" v-for="item in filteredWidth">


                            {{ item.height }}x{{ item.width }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="form-floating mb-3">
                <select class="form-select"
                        v-model="doorForm.opening_type"
                        @invalid="alert('Вы не выбрали вариант открывания и толщину двери!')"
                        id="floatingSelect" aria-label="Floating label select example" required>
                    <option :value="{title:null}">Выберите один из вариантов</option>
                    <option :value="item" v-for="item in getDictionary.opening_variants">{{ item.title }} (толщина
                        {{ item.depth }}
                        мм)
                    </option>
                </select>
                <label for="floatingSelect"><i class="fa-brands fa-openid"></i> Тип открытия двери и толщина</label>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="form-floating mb-3">
                <select class="form-select"
                        v-model="doorForm.loops"
                        @invalid="alert('Вы не выбрали сторону петель!')"
                        id="floatingSelect" aria-label="Floating label select example" required>
                    <option :value="{title:null}">Выберите один из вариантов</option>
                    <option :value="item" v-for="item in getDictionary.loops_variants">{{ item.title }}</option>
                </select>
                <label for="floatingSelect"><i class="fa-solid fa-angles-left"></i> Сторона петель</label>
            </div>
        </div>

        <div class="col-md-6 col-12  mb-3">
            <div class="form-floating">
                <select class="form-select"
                        @change="selectFrontSideFinish"
                        @invalid="alert('Вы не выбрали отделку первой стороны двери!')"
                        v-model="doorForm.front_side_finish"
                        id="floatingSelect" aria-label="Floating label select example" required>
                    <option :value="{title:null}">Выберите один из вариантов</option>
                    <option :value="item" v-for="item in getDictionary.finishes_variants">
                        {{
                            item.title
                        }}
                    </option>
                </select>
                <label for="floatingSelect"><i class="fa-solid fa-paint-roller"></i> Отделка первой стороны (<small>вровень
                    со стеной</small>)</label>
            </div>
            <p v-if="priceForSide('front_side_finish')===0"><small><em><strong class="text-danger">Внимание!</strong>
                сочетание размера и материала не доступно для заказа!</em></small></p>
        </div>

        <div class="col-md-6 col-12 mb-3">
            <div class="form-floating ">
                <select class="form-select"
                        @change="selectBackSideFinish"
                        @invalid="alert('Вы не выбрали отделку второй стороны двери!')"
                        v-model="doorForm.back_side_finish"
                        id="floatingSelect" aria-label="Floating label select example" required>
                    <option :value="{title:null}">Выберите один из вариантов</option>
                    <option :value="item" v-for="item in getDictionary.finishes_variants">{{
                            item.title
                        }}
                    </option>
                </select>
                <label for="floatingSelect"><i class="fa-solid fa-paint-roller"></i> Отделка второй стороны</label>
            </div>
            <p v-if="priceForSide('back_side_finish')===0"><small><em><strong class="text-danger">Внимание!</strong>
                сочетание размера и материала не доступно для заказа!</em></small></p>

        </div>


        <div class="col-md-6 col-12">

            <div class="input-group mb-3">
                <span class="input-group-text border-secondary"
                      v-if="isHex(doorForm.front_side_finish_color.title)"
                      v-bind:style="{'background-color':doorForm.front_side_finish_color.title}"
                      id="basic-addon1" style="width: 40px;">
                </span>
                <div class="form-floating">
                    <input type="text"
                           v-model="doorForm.front_side_finish_color.title"
                           @invalid="alert('Вы не указали лицевую отделку двери!')"
                           class="form-control" id="front_side_finish_color" required>
                    <label for="front_side_finish_color"><i class="fa-solid fa-palette"></i> Цвет отделки первой стороны</label>
                </div>
                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#" @click="doorForm.front_side_finish_color = {title:null}">Не
                        выбрано</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item"
                           @click="selectColor('front_side_finish_color',item)"
                           v-bind:class="{'bg-primary text-white':doorForm.front_side_finish_color.title===item.title}"
                           href="#" v-for="item in filteredSideFinishColors">{{ item.title }}</a></li>
                </ul>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="input-group mb-3">
                 <span class="input-group-text border-secondary"
                       v-if="isHex(doorForm.back_side_finish_color.title)"
                       v-bind:style="{'background-color':doorForm.back_side_finish_color.title}"
                       id="basic-addon1" style="width: 40px;">
                </span>
                <div class="form-floating">
                    <input type="text"
                           @invalid="alert('Вы не указали внутреннюю отделку двери!')"
                           v-model="doorForm.back_side_finish_color.title"
                           class="form-control" id="back_side_finish_color" required>
                    <label for="back_side_finish_color"><i class="fa-solid fa-palette"></i> Цвет отделки второй стороны</label>
                </div>
                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#" @click="doorForm.back_side_finish_color = {title:null}">Не
                        выбрано</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item"
                           @click="selectColor('back_side_finish_color',item)"
                           v-bind:class="{'bg-primary text-white':doorForm.back_side_finish_color.title===item.title }"
                           href="#" v-for="item in filteredSideFinishColors">{{ item.title }}</a></li>
                </ul>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="input-group mb-3">
                 <span class="input-group-text border-secondary"
                       v-if="isHex(doorForm.box_and_frame_color.title)"
                       v-bind:style="{'background-color':doorForm.box_and_frame_color.title}"
                       id="basic-addon1" style="width: 40px;">
                </span>
                <div class="form-floating">
                    <input type="text"
                           @invalid="alert('Вы не выбрали цвет короба и каркаса')"
                           v-model="doorForm.box_and_frame_color.title"
                           class="form-control" id="box_and_frame_color" required>
                    <label for="box_and_frame_color"><i class="fa-solid fa-palette"></i> Цвет короба и каркаса</label>
                </div>
                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#" @click="doorForm.box_and_frame_color = {title:null}">Не
                        выбрано</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item"
                           v-bind:class="{'bg-primary text-white':doorForm.box_and_frame_color.title===item.title }"
                           @click="selectColor('box_and_frame_color',item)"
                           href="#" v-for="item in filteredBoxAndFrameColors">{{ item.title }}</a></li>
                </ul>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="input-group mb-3">
                   <span class="input-group-text border-secondary"
                         v-if="isHex(doorForm.seal_color.title)"
                         v-bind:style="{'background-color':doorForm.seal_color.title}"
                         id="basic-addon1" style="width: 40px;">
                </span>
                <div class="form-floating">
                    <input type="text"
                           @invalid="alert('Вы не выбрали цвет уплотнителя')"
                           v-model="doorForm.seal_color.title"
                           class="form-control" id="seal_color" required>
                    <label for="seal_color"><i class="fa-solid fa-palette"></i> Цвет уплотнителя</label>
                </div>
                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#" @click="doorForm.seal_color = {title:null}">Не выбрано</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item"
                           v-bind:class="{'bg-primary text-white':doorForm.seal_color.title===item.title }"
                           @click="selectColor('seal_color',item)"
                           href="#" v-for="item in filteredSealColors">{{ item.title }}</a></li>
                </ul>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="input-group mb-3">
                <span class="input-group-text border-secondary"
                      v-if="isHex(doorForm.fittings_color.title)"
                      v-bind:style="{'background-color':doorForm.fittings_color.title}"
                      id="basic-addon1" style="width: 40px;">
                </span>
                <div class="form-floating">
                    <input type="text"
                           @invalid="alert('Вы не выбрали цвет фурнитуры')"
                           v-model="doorForm.fittings_color.title"
                           class="form-control" id="fittings_color" required>
                    <label for="fittings_color"><i class="fa-solid fa-palette"></i> Цвет фурнитуры</label>
                </div>
                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#" @click="doorForm.fittings_color = {title:null}">Не выбрано</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item"
                           v-bind:class="{'bg-primary text-white':doorForm.fittings_color.title===item.title }"
                           @click="selectColor('fittings_color',item)"
                           href="#" v-for="item in filteredFittingsColors">{{ item.title }}</a></li>
                </ul>
            </div>
        </div>


        <div class="col-12">
            <div class="form-check form-switch">
                <input class="form-check-input"
                       v-model="doorForm.need_upper_jumper"
                       type="checkbox" role="switch" id="need-upper-jumper" checked>
                <label class="form-check-label" for="need-upper-jumper">
                    Нужна верхняя перемычка
                </label>
            </div>
        </div>

        <div class="col-12">
            <div class="form-check form-switch">
                <input class="form-check-input"
                       v-model="doorForm.need_handle_holes"
                       type="checkbox" role="switch" id="need-handle-holes" checked>
                <label class="form-check-label" for="need-handle-holes">
                    Нужна ручка \ не нужна ручка
                </label>
            </div>
        </div>

        <div class="col-md-6 col-12" v-if="doorForm.need_handle_holes">
            <div class="form-floating mb-3">
                <select class="form-select"
                        @invalid="alert('Вы не выбрали отверстие под ручку!')"
                        v-model="doorForm.handle_holes"
                        id="floatingSelect" aria-label="Floating label select example" required>
                    <option :value="{title:null}">Выберите один из вариантов</option>
                    <option :value="item" v-for="item in getDictionary.handle_holes_variants">{{
                            item.title
                        }}
                    </option>
                </select>
                <label for="floatingSelect">Отверстий под ручку</label>
            </div>
        </div>

        <div class="col-md-6 col-12" v-if="doorForm.need_handle_holes&&doorForm.handle_holes.id!==3">
            <div class="form-floating mb-3">
                <select class="form-select"
                        @invalid="alert('Вы не выбрали внешний вид ручки!')"
                        v-model="doorForm.handle_holes_type"
                        id="floatingSelect" aria-label="Floating label select example" required>
                    <option :value="{title:null}">Выберите один из вариантов</option>
                    <option :value="item" v-for="item in getDictionary.handle_holes_type_variants">{{
                            item.title
                        }}
                    </option>
                </select>
                <label for="floatingSelect">Внешний вид ручки</label>
            </div>
        </div>

        <div class="col-12"
             v-if="(doorForm.handle_holes_type.variants||[]).length>0&&doorForm.need_handle_holes&&doorForm.handle_holes.id!==3">
            <div class="row">

                <div class="col-12">
                    <p class="mb-2">Цвет ручки {{ doorForm.handle_holes_type.color || 'не указан' }}
                        <span
                            class="d-inline-block"
                            v-bind:style="{'background-color': doorForm.handle_holes_type.color }"
                            style="width:50px; height: 10px;"
                            v-if="doorForm.handle_holes_type.color"
                        >
                        </span>
                    </p>

                </div>
                <div class="col-lg-3 col-md-3 col-12 mb-2"
                     v-for="(item, index) in doorForm.handle_holes_type.variants">
                    <div class="card cursor-pointer"
                         v-bind:class="{'border-secondary shadow-lg':item.selected}"
                         @click="selectSideFinish('handle_holes_type','variants',index)">
                        <img v-lazy="item.image" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h6 class="font-bold" v-if="item.title">{{ item.title || 'не указано' }}</h6>
                            <p class="card-text" v-if="item.description">{{ item.description || 'не указано' }}</p>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-12" v-if="(doorForm.handle_holes_type.variants||[]).length===0&&doorForm.need_handle_holes">

            <div class="alert alert-success" role="alert">
                <p>Вариантов изображений ручки нет</p>
            </div>
        </div>

        <div class="col-12">
            <div class="form-check form-switch">
                <input class="form-check-input"
                       type="checkbox"

                       v-model="doorForm.need_automatic_doorstep"
                       role="switch" id="need-automatic-doorstep" checked>
                <label class="form-check-label" for="need-automatic-doorstep">
                    Нужен автоматический порог \ не нужен
                </label>
            </div>
        </div>

        <div class="col-12">
            <div class="form-check form-switch">
                <input class="form-check-input"
                       type="checkbox" role="switch"
                       v-model="doorForm.need_hidden_stopper"
                       id="need-hidden-stopper" checked>
                <label class="form-check-label" for="need-hidden-stopper">
                    Нужен скрытый стопор \ не нужен
                </label>
            </div>
        </div>

        <div class="col-12">
            <div class="form-check form-switch">
                <input class="form-check-input"
                       v-model="doorForm.need_hidden_door_closer"
                       type="checkbox" role="switch" id="need-hidden-door-closer" checked>
                <label class="form-check-label" for="need-hidden-door-closer">
                    Нужен скрытый доводчик \ не нужен
                </label>
            </div>
        </div>

        <div class="col-12">
            <div class="form-check form-switch">
                <input class="form-check-input"
                       v-model="doorForm.need_hidden_skirting_board"
                       type="checkbox" role="switch" id="need-hidden-skirting-board" checked>
                <label class="form-check-label" for="need-hidden-skirting-board">
                    Нужен скрытый плинтус \ не нужен
                </label>
            </div>
        </div>

        <div class="col-12">
            <div class="form-check form-switch">
                <input class="form-check-input"
                       type="checkbox"
                       v-model="doorForm.need_door_install"
                       role="switch" id="need-door-install" checked>
                <label class="form-check-label" for="need-door-install">
                    Нужен установка двери \ не нужна
                </label>
            </div>
        </div>

        <div class="col-md-6 col-12 ">
            <p class="mr-2 text-center my-2 font-bold">Количество дверей с такой отделкой</p>
            <div class="card w-100">
                <div class="card-body">

                    <div class="row">
                        <div class="col-12 mb-2" v-bind:class="{'col-md-6':doorForm.price_type.id===3}">
                            <div class="form-floating">
                                <select class="form-select"
                                        v-model="doorForm.price_type"
                                        @invalid="alert('Вы не выбрали тип цены!')"
                                        id="door-type" aria-label="door-type" required>
                                    <option :value="{title:null}">Выберите один из вариантов</option>
                                    <option :value="item"
                                            v-for="item in getDictionary.price_type_variants">{{
                                            item.title
                                        }}
                                    </option>
                                </select>
                                <label for="door-type">Тип цены</label>
                            </div>
                        </div>
                        <div class="col-md-6"
                             v-if="doorForm.price_type.id===3">
                            <div class="form-floating">
                                <input type="number"
                                       min="0"
                                       @invalid="alert('Вы не ввели процент дилера!')"
                                       v-model="doorForm.dealer_percent"
                                       class="form-control text-center" id="floatingInput" required>
                                <label for="floatingInput">Процент дилера</label>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="card-body d-flex justify-content-between ">
                    <div class="p-2">
                        <button type="button"
                                @click="changeDoorCount('sub')"
                                class="btn btn-outline-danger">
                            <i class="fa-solid fa-minus"></i>
                        </button>

                    </div>
                    <div class="input-group p-2">
                        <input type="number"
                               @invalid="alert('Вы не указали количество дверей')"
                               v-model="doorForm.count"
                               min="1" value="1" class="form-control rounded-2 text-center">
                    </div>
                    <div class="p-2">
                        <button type="button"
                                @click="changeDoorCount('add')"
                                class="btn btn-outline-success">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <button
                        type="button"
                        class="btn btn-outline-primary rounded-5 w-100 mb-2"
                        data-bs-toggle="modal" data-bs-target="#door-preview">Посмотреть превью
                    </button>
                    <button
                        :disabled="!doorForm.price_type.key"
                        class="btn btn-outline-success rounded-5 w-100">Сохранить</button>
                </div>
            </div>
        </div>


        <div class="col-md-6 col-lg-6 col-12">
            <p class="mr-2 text-center my-2 font-bold">Суммарно</p>
            <div class="card">
                <div class="card-body">
                    <h6 class="font-bold my-2" data-bs-toggle="modal" data-bs-target="#choose-image">Итого</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td>Характеристики</td>
                                <td>
                                    <h6 class="text-muted font-bold">{{ doorForm.door_type.title }} {{
                                            doorForm.width
                                        }}x{{ doorForm.height }}x{{ doorForm.depth }}
                                    </h6>
                                    <h6 class="text-black mb-0">

                                            <span
                                                v-if="doorForm.box_and_frame_color.title">({{
                                                    doorForm.box_and_frame_color.title
                                                }})</span>

                                        <span
                                            v-if="doorForm.front_side_finish.title">лицо {{
                                                doorForm.front_side_finish.title
                                            }} </span>
                                        <span v-if="doorForm.back_side_finish.title">/ {{
                                                doorForm.back_side_finish.title
                                            }}</span>
                                        <span v-if="doorForm.loops.title">петли {{ doorForm.loops.title }}</span>
                                        <span
                                            v-if="doorForm.hinge_manufacturer.title ">{{
                                                doorForm.hinge_manufacturer.title
                                            }}</span>
                                        <span v-if="doorForm.fittings_color.title">({{
                                                doorForm.fittings_color.title
                                            }}),</span>
                                        <span v-if="doorForm.opening_type.title">{{
                                                doorForm.opening_type.title
                                            }},</span>
                                        <span v-if="doorForm.handle_holes.title">{{
                                                doorForm.handle_holes.title
                                            }}</span>
                                    </h6>
                                </td>
                            </tr>
                            <tr>
                                <td>Цена</td>

                                <td>
                                    <p v-if="doorForm.price_type.key">
                                        <strong>{{
                                                resultPrice
                                            }}₽</strong>
                                        x{{ doorForm.count || 0 }} =
                                        <strong>{{
                                                resultPrice * doorForm.count
                                            }}₽</strong>
                                    </p>
                                    <p v-else>
                                        Необходимо выбрать тип цены
                                    </p>

                                </td>
                            </tr>
                            </tbody>
                        </table>


                    </div>


                </div>
            </div>
        </div>


        <div class="row d-flex justify-content-center">
            <div class="col-12">

                <div
                    @click="removeMessage(index)"
                    v-if="messages.length>0"
                    v-for="(message, index) in messages"
                    class="alert alert-danger alert-dismissible fade show my-2" role="alert">
                    <strong>Внимание!</strong> {{ message || 'Ошибка' }}
                </div>

            </div>
        </div>
    </form>


    <!-- Modal -->
    <div class="modal fade" :id="'choose-color-'+doorForm.id" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
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

    <!-- Modal -->
    <div class="modal fade" :id="'finish-front-variant-modal-'+doorForm.id" tabindex="-1"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Выбор типа материала для первый стороны</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <MaterialSelectForm
                        v-model:item="doorForm.front_side_finish">
                    </MaterialSelectForm>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary text-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Закрыть
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" :id="'finish-back-variant-modal-'+doorForm.id" tabindex="-1"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Выбор типа материала для второй стороны</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">

                    <MaterialSelectForm v-model:item="doorForm.back_side_finish">

                    </MaterialSelectForm>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary text-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Закрыть
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="fixed-price btn btn-outline-primary rounded-5 shadow-lg d-sm-none d-md-block" v-if="resultPrice>0">
        <span class="text-center badge text-primary font-bold">{{ resultPrice }}₽</span>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="door-preview" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Превью двери</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <DoorPreview
                        :door="doorForm">
                    </DoorPreview>

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
    props: ['door'],
    data() {
        return {
            messages: [],
            filterHeight: null,
            filterWidth: null,
            selectedColorParam: null,
            colorModal: null,
            finishFrontVariantModal: null,
            finishBackVariantModal: null,

            doorForm: {
                id: null,
                width: 0,
                height: 0,
                depth: 0,
                count: 1,
                price: 0,
                size: null,
                purpose: null,
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
                need_handle_holes: false, //нужна дверная ручка
                need_upper_jumper: false, //Верхняя перемычка
                need_automatic_doorstep: false, //Автоматический порог
                need_hidden_stopper: false, //Скрытый стопор
                need_hidden_door_closer: false, //Скрытый доводчик
                need_hidden_skirting_board: false, //нужен плинтус
                need_door_install: false //нужна установка двери
            }
        }
    },
    computed: {
        ...mapGetters(['getErrors', 'getDictionary', 'cartTotalCount', 'cartProducts', 'cartTotalPrice']),

        filteredSideFinishColors() {
            let colors = this.getDictionary.color_variants
            return colors.filter(item => item.type === "side_finish" || item.type === "all")
        },
        filteredBoxAndFrameColors() {
            let colors = this.getDictionary.color_variants
            return colors.filter(item => item.type === "box_and_frame" || item.type === "all")
        },
        filteredFittingsColors() {
            let colors = this.getDictionary.color_variants
            return colors.filter(item => item.type === "fittings" || item.type === "all")
        },
        filteredSealColors() {
            let colors = this.getDictionary.color_variants
            return colors.filter(item => item.type === "seal" || item.type === "all")
        },

        resultPrice() {
            return (this.doorForm.price_type.id !== 3) ? this.summaryPrice : this.summaryPriceWithDealer
        },
        summaryPriceWithDealer() {
            return Math.round((this.summaryPrice || 0) * (1 + ((this.doorForm.dealer_percent || 0) / 100)))
        },
        summaryPrice() {
            let sum = 0;


            let type = this.doorForm.price_type.key

            Object.keys(this.doorForm).forEach(item => {

                if (item) {

                    if (typeof this.doorForm[item] === "object" && this.doorForm[item] != null) {

                        if (this.doorForm[item].price) {
                            sum += (typeof this.doorForm[item].price === "object") ?
                                (this.doorForm[item].price[type] || 0) :
                                (this.doorForm[item].price || 0)
                        }

                    }
                }

            })

            let basePrices = this.getDictionary.prices

            let price = 0

            let find = false
            let section = null;
            basePrices.forEach(item => {

                if (item.width === this.doorForm.width && item.height === this.doorForm.height) {
                    find = true
                    section = item;
                }


            })


            if (find) {
                section.materials.forEach(sub => {
                    if (sub.id === this.doorForm.front_side_finish.id) {
                        price += typeof sub.price === "object" ? sub.price[type] : sub.price
                    }

                    if (sub.id === this.doorForm.back_side_finish.id) {
                        price += typeof sub.price === "object" ? sub.price[type] : sub.price
                    }

                })


            } else {

                for (let i = 0; i < basePrices.length; i++) {
                    if (basePrices[i].width >= this.doorForm.width && basePrices[i].height >= this.doorForm.height) {

                        basePrices[i].materials.forEach(sub => {
                            if (sub.id === this.doorForm.front_side_finish.id)
                                price += typeof sub.price === "object" ? sub.price[type] : sub.price
                        })

                        basePrices[i].materials.forEach(sub => {
                            if (sub.id === this.doorForm.back_side_finish.id)
                                price += typeof sub.price === "object" ? sub.price[type] : sub.price
                        })
                        break;
                    }
                }
            }


            return sum + price;//this.doorForm.dealer_percent > 0 ? (sum + price) * (1 + (this.doorForm.dealer_percent / 100)) : sum + price;
        },
        filteredHeight() {
            if (!this.getDictionary)
                return []

            if (!this.filterHeight)
                return this.getDictionary.size_variants

            return this.getDictionary.size_variants
                .filter(item => ("" + item.height).indexOf(this.filterHeight) !== -1)
        },
        filteredWidth() {
            if (!this.getDictionary)
                return []

            if (!this.filterWidth)
                return this.getDictionary.size_variants

            return this.getDictionary.size_variants
                .filter(item => ("" + item.width).indexOf(this.filterWidth) !== -1)
        }
    },
    watch: {

        'doorForm.need_handle_holes': {
            handler(val) {
                if (!this.doorForm.need_handle_holes) {
                    this.doorForm.handle_holes = {title: null}
                    this.doorForm.handle_holes_type = {title: null}
                }

            },
            deep: true
        },
        'doorForm.opening_type': {
            handler(val) {
                if (this.doorForm.opening_type) {
                    let item = this.getDictionary.opening_variants.find(item => item.id === this.doorForm.opening_type.id)
                    if (item)
                        this.doorForm.depth = item.depth || 0
                }

            },
            deep: true
        },
        'summaryPriceWithDealer': {
            handler(val) {
                //if (this.doorForm.price_type.id === 3)
                this.doorForm.price = this.summaryPriceWithDealer

            },
            deep: true
        },
        'summaryPrice': {
            handler(val) {
                //if (this.doorForm.price_type.id !== 3)
                this.doorForm.price = this.summaryPrice

            },
            deep: true
        }
    },

    mounted() {

        if (!this.door) {
            this.doorForm.id = uuid.v1()
            this.clearForm(false)
        } else {
            this.$nextTick(() => {
                this.doorForm = {
                    id: this.door.product.id,
                    width: this.door.product.width,
                    height: this.door.product.height,
                    depth: this.door.product.depth,
                    count: this.door.quantity,
                    size: this.door.product.size,
                    purpose: this.door.product.purpose || null,
                    handle_holes: this.door.product.handle_holes || null,
                    handle_holes_type: this.door.product.handle_holes_type || null,
                    opening_type: this.door.product.opening_type || null,
                    box_and_frame_color: this.door.product.box_and_frame_color || null,
                    door_type: this.door.product.door_type || null,
                    front_side_finish: this.door.product.front_side_finish || null,
                    back_side_finish: this.door.product.back_side_finish || null,
                    front_side_finish_color: this.door.product.front_side_finish_color || null,
                    back_side_finish_color: this.door.product.back_side_finish_color || null,
                    seal_color: this.door.product.seal_color || null,
                    fittings_color: this.door.product.fittings_color || null,
                    loops: this.door.product.loops || null,
                    loops_count: this.door.product.loops_count || 0,
                    price_type: this.door.product.price_type || null,
                    hinge_manufacturer: this.door.product.hinge_manufacturer || null,

                }
            })
        }

    },
    methods: {
        selectSideFinish(section, param, index) {

            let isSelected = this.doorForm[section][param][index].selected || false

            if (!isSelected)
                this.doorForm[section][param].forEach(item => {
                    if (item.selected)
                        delete item.selected
                })
            this.doorForm[section][param][index].selected =
                !(this.doorForm[section][param][index].selected)

        },
        priceForSide(param) {
            let type = this.doorForm.price_type.key
            let price = 0
            let section = null;
            let basePrices = this.getDictionary.prices

            if (this.doorForm.width === 0 && this.doorForm.height === 0)
                return 0;

            basePrices.forEach(sub => {
                if (this.doorForm.width === sub.width && this.doorForm.height === sub.height) {
                    section = sub;
                }
            })

            if (section.materials)
                section.materials.forEach(sub => {
                    if (sub.id === this.doorForm[param].id) {
                        price = typeof sub.price === "object" ? sub.price[type] : sub.price
                    }

                })
            return price
        },
        isHex(num) {
            return /^#[0-9A-F]{6}$/i.test(num)
        },
        callbackSelectColor(item) {
            this.doorForm[this.selectedColorParam].title = item.color.hex
            this.doorForm[this.selectedColorParam].code = item.color.code || item.color.hex || null

            this.colorModal.hide()
        },
        selectColor(param, item) {

            this.doorForm[param] = {
                title: item.code || null,
                code: item.code || null,
                price: item.price || 0,
                type: item.type || 'all',
            }

            if (item.title === "RAL") {
                this.selectedColorParam = param

                this.doorForm[param] = {
                    title: 'RAL',
                    code: 'RAL',
                    price: item.price || 0,
                    type: item.type || 'all',
                }

                this.colorModal = new bootstrap.Modal(document.getElementById('choose-color-' + this.doorForm.id), {})
                this.colorModal.show()
            }

        },
        clearForm(needTestData = false) {
            if (needTestData)
                this.doorForm = {
                    id: uuid.v1(),
                    width: 0,
                    height: 0,
                    depth: 0,
                    count: 0,
                    size: null,
                    purpose: "test",
                    handle_holes: this.getDictionary.handle_holes_variants[0],
                    handle_holes_type: this.getDictionary.handle_holes_type_variants[0],
                    opening_type: this.getDictionary.opening_variants[0],
                    box_and_frame_color: this.getDictionary.color_variants[0],
                    door_type: this.getDictionary.door_variants[0],
                    front_side_finish: this.getDictionary.finishes_variants[0],
                    back_side_finish: this.getDictionary.finishes_variants[0],
                    front_side_finish_color: this.getDictionary.color_variants[0],
                    back_side_finish_color: this.getDictionary.color_variants[0],
                    seal_color: this.getDictionary.color_variants[0],
                    fittings_color: this.getDictionary.color_variants[0],
                    loops: this.getDictionary.loops_variants[0],//расположение петель
                    loops_count: 2,
                    price_type: this.getDictionary.price_type_variants[0],
                    hinge_manufacturer: this.getDictionary.hinge_manufacturer_variants[0],

                }
            else
                this.doorForm = {
                    id: uuid.v1(),
                    width: 0,
                    height: 0,
                    depth: 0,
                    count: 1,
                    price: 0,
                    size: null,
                    purpose: null,
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
                    need_handle_holes: false, //нужна дверная ручка
                    need_upper_jumper: false, //Верхняя перемычка
                    need_automatic_doorstep: false, //Автоматический порог
                    need_hidden_stopper: false, //Скрытый стопор
                    need_hidden_door_closer: false, //Скрытый доводчик
                    need_hidden_skirting_board: false, //нужен плинтус
                    need_door_install: false //нужна установка двери
                }
        },
        selectDoorSize(item) {

            if (item == null) {
                this.doorForm.width = 0
                this.doorForm.height = 0
                this.doorForm.size = null
                this.doorForm.loops_count = 0
                return
            }
            this.doorForm.width = item.width
            this.doorForm.height = item.height
            this.doorForm.size = item
            this.doorForm.loops_count = item.loops_count
        },
        changeDoorCount(direction) {
            if (direction === 'add')
                this.doorForm.count++

            if (direction === 'sub' && this.doorForm.count > 0)
                this.doorForm.count--;
        },
        selectFrontSideFinish() {
            if ((this.doorForm.front_side_finish.door_variants || []).length === 0)
                return

            this.finishFrontVariantModal = new bootstrap.Modal(document.getElementById('finish-front-variant-modal-' + this.doorForm.id), {})
            this.finishFrontVariantModal.show()


        },
        selectBackSideFinish() {
            if ((this.doorForm.back_side_finish.door_variants || []).length === 0)
                return

            this.finishBackVariantModal = new bootstrap.Modal(document.getElementById('finish-back-variant-modal-' + this.doorForm.id), {})
            this.finishBackVariantModal.show()


        },
        alert(msg) {
            this.messages.push(msg)
        },
        removeMessage(index) {
            this.messages.splice(index, 1)
        },
        submitForm() {
            this.messages = []

            this.$store.dispatch("addProductToCart", this.doorForm).then(() => {

                this.doorForm.id = uuid.v1()

                this.$emit("callback")

                this.$notify({
                    title: "DoDoors",
                    text: "Дверь успешно добавлена в корзину",
                });
            })
        }
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
</style>
