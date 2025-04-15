<script setup>
import DoorPreview from "@/Components/Doors/DoorPreview.vue";
import MaterialSelectForm from "@/Components/Doors/MaterialSelectForm.vue";
import ColorSelector from "@/Components/Calc/ColorSelector.vue";
import HandleDetail from "@/Components/Admin/Handles/HandleDetail.vue";
import HandleSearchModal from "@/Components/Admin/Handles/HandleSearchModal.vue";
import WrapperSearchModal from "@/Components/Admin/Handles/WrapperSearchModal.vue";
</script>

<template>

    <form class="row" v-on:submit.prevent="submitForm" v-if="loaded">

        <div class="col-md-6">


            <div class="row">
                <div class="col-md-6 col-12 mb-2">
                    <button
                        type="button"
                        @click="openConfirmModal('Внимание!','Вы очищает текущую работу в калькуляторе! Продолжить?')"
                        class="btn rounded-0 w-100 btn-dark p-3">Очистить форму
                    </button>
                </div>

                <div class="col-md-6 col-12">
                    <div class="input-group mb-2">
                        <div class="form-floating">
                            <input type="text"
                                   min="0"
                                   v-model="doorForm.purpose"
                                   class="form-control" id="floatingInput">
                            <label for="floatingInput"><i class="fa-solid fa-signs-post"></i> Назначение
                                двери</label>
                        </div>
                        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                            <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end rounded-0">
                            <li><a class="dropdown-item"
                                   @click="doorForm.purpose = null"
                                   href="javascript:void(0)">Не выбрано</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item"
                                   @click="doorForm.purpose = item"
                                   v-bind:class="{'bg-primary text-white':doorForm.purpose===item}"
                                   href="javascript:void(0)" v-for="item in getDictionary.purpose_variants">{{
                                    item
                                }}</a>
                            </li>
                        </ul>
                    </div>
                </div>


                <div class="col-md-6 col-12">
                    <div class="input-group mb-2">
                        <div class="form-floating">
                            <input type="number"
                                   min="0"
                                   @invalid="alert('Вы не выбрали \ ввели высоту двери!')"
                                   v-model="doorForm.height"
                                   class="form-control" id="floatingInput" required>
                            <label for="floatingInput"><i class="fa-solid fa-ruler-vertical"></i> Высота, мм</label>
                        </div>
                        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                            <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end rounded-0">
                            <li><a class="dropdown-item" href="javascript:void(0)" @click="selectDoorSize(null)">Не
                                выбрано</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="p-1">
                                <div class="form-floating">
                                    <input type="search"
                                           v-model="filterHeight"
                                           class="form-control" id="filtered-height" placeholder="name@example.com">
                                    <label for="filtered-height">Фильтр высоты</label>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="scrollable-menu p-2">

                                <a class="dropdown-item"
                                   @click="selectDoorSize(item)"
                                   v-bind:class="{'bg-primary':doorForm.width===item.width&&doorForm.width===item.height}"
                                   href="javascript:void(0)" v-for="item in filteredHeight">


                                    {{ item.height }}x{{ item.width }}
                                </a>
                                <p v-if="filteredHeight.length===0" class="text-center">Ничего не найдено</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="input-group mb-2">

                        <div class="form-floating">
                            <input type="number"
                                   min="0"
                                   @invalid="alert('Вы не выбрали \ ввели ширину двери!')"
                                   v-model="doorForm.width"
                                   class="form-control" id="floatingInput" required>
                            <label for="floatingInput"><i class="fa-solid fa-ruler-horizontal"></i> Ширина,
                                мм</label>
                        </div>
                        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                            <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end rounded-0">
                            <li><a class="dropdown-item" href="javascript:void(0)" @click="selectDoorSize(null)">Не
                                выбрано</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="p-1">
                                <div class="form-floating">
                                    <input type="search"
                                           v-model="filterWidth"
                                           class="form-control" id="filtered-height" placeholder="name@example.com">
                                    <label for="filtered-height">Фильтр ширины</label>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="scrollable-menu p-2">

                                <a class="dropdown-item"
                                   @click="selectDoorSize(item)"
                                   v-bind:class="{'bg-primary text-white':doorForm.width===item.width&&doorForm.width===item.height}"
                                   href="javascript:void(0)" v-for="item in filteredWidth">


                                    {{ item.height }}x{{ item.width }}
                                </a>
                                <p v-if="filteredWidth.length===0" class="text-center">Ничего не найдено</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-floating mb-2">
                        <select class="form-select"
                                v-model="doorForm.opening_type"
                                @invalid="alert('Вы не выбрали вариант открывания и толщину двери!')"
                                id="floatingSelect" aria-label="Floating label select example" required>
                            <option :value="{title:null}">Выберите один из вариантов</option>
                            <option :value="item" v-for="item in getDictionary.opening_variants">{{ item.title }}
                                (толщина
                                {{ item.depth }}
                                мм)
                            </option>
                        </select>
                        <label for="floatingSelect"><i class="fa-brands fa-openid"></i> Тип открытия двери и
                            толщина</label>
                    </div>
                </div>

                <div class="col-md-6 col-12">


                    <div class="form-floating mb-2">

                        <select class="form-select"
                                v-model="doorForm.door_type"
                                @invalid="alert('Вы не выбрали тип двери!')"
                                id="door-type" aria-label="door-type" required>
                            <option :value="item" v-for="item in getDictionary.door_variants">{{
                                    item.title
                                }}
                            </option>
                        </select>
                        <label for="door-type"><i class="fa-solid fa-door-open"></i> Выберите тип двери</label>
                    </div>
                </div>


                <div class="col-md-6 col-12">

                    <div class="form-floating mb-2">
                        <select class="form-select"
                                v-model="doorForm.hinge_manufacturer"
                                @invalid="alert('Вы не выбрали расположение петель!')"
                                id="floatingSelect" aria-label="Floating label select example" required>
                            <option :value="item" v-for="item in getDictionary.hinge_manufacturer_variants">{{
                                    item.title
                                }}
                            </option>
                        </select>
                        <label for="floatingSelect"><i class="fa-solid fa-industry"></i> Производитель
                            петель</label>
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div class="form-floating mb-2">
                        <select class="form-select"
                                v-model="doorForm.loops"
                                @invalid="alert('Вы не выбрали сторону петель!')"
                                id="floatingSelect" aria-label="Floating label select example" required>
                            <option :value="item" v-for="item in getDictionary.loops_variants">{{
                                    item.title
                                }}
                            </option>
                        </select>
                        <label for="floatingSelect"><i class="fa-solid fa-angles-left"></i> Сторона петель</label>
                    </div>
                </div>


                <div class="col-md-6 col-12  mb-2">

                    <div class="input-group">

                        <div class="form-floating">
                            <select class="form-select"

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
                            <label for="floatingSelect"><i class="fa-solid fa-paint-roller"></i> Отделка первой
                                стороны
                            </label>
                        </div>

                        <button
                            v-if="(doorForm.front_side_finish.door_variants || []).length !== 0"
                            @click="selectFrontSideFinish"
                            class="btn btn-outline-secondary rounded-0" type="button">
                            <i class="fa-solid fa-images"></i>
                        </button>


                    </div>


                    <p v-if="priceForSide('front_side_finish')===0" style="line-height: 100%;"><small><em><strong
                        class="text-danger">Внимание!</strong>
                        сочетание размера и материала не доступно для заказа!</em></small></p>
                </div>


                <div class="col-md-6 col-12">
                    <ColorSelector
                        :material="doorForm.front_side_finish"
                        :filter="'front_side_finish_color'"
                        v-if="doorForm.front_side_finish.title!=='Под покраску'"
                        @invalid="alert('Вы не выбрали цвет отделки первой стороны')"
                        v-model="doorForm.front_side_finish_color">
                        <template #name>
                            Цвет отделки первой стороны
                        </template>
                    </ColorSelector>
                    <div class="card rounded-0" v-else>
                        <div class="card-body p-3 disabled-element">
                            <p class="text-center">Выбрано "Под покраску"</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-12 mb-2">
                    <div class="input-group">
                        <div class="form-floating ">
                            <select class="form-select"
                                    @invalid="alert('Вы не выбрали отделку второй стороны двери!')"
                                    v-model="doorForm.back_side_finish"
                                    id="floatingSelect" aria-label="Floating label select example" required>
                                <option :value="{title:null}">Выберите один из вариантов</option>
                                <option :value="item" v-for="item in getDictionary.finishes_variants">{{
                                        item.title
                                    }}
                                </option>
                            </select>
                            <label for="floatingSelect"><i class="fa-solid fa-paint-roller"></i> Отделка второй
                                стороны</label>
                        </div>
                        <button
                            v-if="(doorForm.back_side_finish.door_variants || []).length !== 0"
                            @click="selectBackSideFinish"
                            class="btn btn-outline-secondary rounded-0" type="button">
                            <i class="fa-solid fa-images"></i>
                        </button>

                    </div>
                    <p v-if="priceForSide('back_side_finish')===0" style="line-height: 100%;"><small><em><strong
                        class="text-danger">Внимание!</strong>
                        сочетание размера и материала не доступно для заказа!</em></small></p>

                </div>

                <div class="col-md-6 col-12 mb-2">
                    {{}}
                    <ColorSelector
                        :material="doorForm.back_side_finish"
                        :filter="'back_side_finish_color'"
                        v-if="doorForm.back_side_finish.title!=='Под покраску'"
                        @invalid="alert('Вы не выбрали цвет отделки второй стороны')"
                        v-model="doorForm.back_side_finish_color">
                        <template #name>
                            Цвет отделки второй стороны
                        </template>
                    </ColorSelector>
                    <div class="card rounded-0" v-else>
                        <div class="card-body p-3 disabled-element">
                            <p class="text-center">Выбрано "Под покраску"</p>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 col-12">

                    <ColorSelector
                        v-if="!color_sync_update"
                        :filter="'box_and_frame_color'"
                        v-on:change="syncColors('box_and_frame_color',$event)"
                        @invalid="alert('Вы не выбрали цвет короба и каркаса')"
                        v-model="doorForm.box_and_frame_color">
                        <template #name>
                            Цвет короба и каркаса
                        </template>
                    </ColorSelector>


                </div>

                <div class="col-md-6 col-12">
                    <ColorSelector
                        v-if="!color_sync_update"
                        :filter="'seal_color'"
                        @invalid="alert('Вы не выбрали цвет уплотнителя')"
                        v-model="doorForm.seal_color">
                        <template #name>
                            Цвет уплотнителя
                        </template>
                    </ColorSelector>

                </div>

                <div class="col-md-6 col-12">

                    <ColorSelector
                        v-if="!color_sync_update"
                        :filter="'fittings_color'"
                        @invalid="alert('Вы не выбрали цвет фурнитуры')"
                        v-model="doorForm.fittings_color">
                        <template #name>
                            Цвет фурнитуры
                        </template>
                    </ColorSelector>

                </div>

                <div class="col-md-6 col-12"
                     v-if="doorForm.fittings_color.title!=null&&doorForm.fittings_color.is_ral">

                    <div class="form-floating w-100">
                        <select class="form-select"
                                v-model="doorForm.service_painting"
                                id="door-service-painting" aria-label="Floating label select example">
                            <option :value="service" v-for="service in getServiceByType('service_painting')">
                                {{ service.title || '-' }}
                            </option>
                        </select>
                        <label for="door-service-painting">Выберите вариант</label>
                    </div>

                </div>


                <div class="col-12">
                    <div class="form-floating ">
                            <textarea class="form-control border-secondary rounded-0"
                                      v-model="doorForm.comment"
                                      style="min-height: 100px;"
                                      placeholder="Оставьте комментарий" id="door-comment"></textarea>
                        <label for="door-comment">Комментарий к двери</label>
                    </div>
                </div>

            </div>

            <div class="row py-3" v-if="need_addition">

                <div class="col-12 d-flex align-items-center">
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
                    <div class="form-floating mb-2">
                        <select class="form-select"
                                @invalid="alert('Вы не выбрали отверстие под ручку!')"
                                v-model="doorForm.handle_holes"
                                id="floatingSelect" aria-label="Floating label select example" required>
                            <!--                                <option :value="{title:null}">Выберите один из вариантов</option>-->
                            <option :value="item" v-for="item in getDictionary.handle_holes_variants">{{
                                    item.title
                                }}
                            </option>
                        </select>
                        <label for="floatingSelect">Отверстия под ручку</label>
                    </div>
                </div>

                <div class="col-md-6 col-12" v-if="doorForm.need_handle_holes&&doorForm.handle_holes.id!==3">
                    <HandleSearchModal v-model="doorForm"/>
                </div>

                <div class="col-md-6 offset-md-6 mb-2 col-12"
                     v-if="doorForm.need_handle_holes&&doorForm.handle_holes.id===2">
                    <WrapperSearchModal v-model="doorForm"/>
                </div>

                <div
                    v-if="doorForm.need_handle_holes&&doorForm.handle_holes.id!==3"
                    class="col-12 d-flex align-items-center">


                </div>

                <div class="col-12"
                     v-if="(doorForm.handle_holes_type.variants||[]).length>0&&doorForm.need_handle_holes&&doorForm.handle_holes.id!==3">
                    <div class="row">

                        <div class="col-12 d-flex justify-content-between">
                            <p class="mb-2">Цвет ручки "{{ doorForm.handle_holes_type.color || 'не указан' }}"
                                <span
                                    class="d-inline-block"
                                    v-bind:style="{'background-color': doorForm.handle_holes_type.color }"
                                    style="width:50px; height: 10px;"
                                    v-if="doorForm.handle_holes_type.color"
                                >
                                </span>


                            </p>
                            <a
                                @click="showDetails(doorForm.handle_holes_type)"
                                href="javascript:void(0)"
                                class="fst-italic cursor-pointer btn btn-link p-0">Дополнительные параметры ручки</a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12 mb-2"
                             v-for="(item, index) in doorForm.handle_holes_type.variants">
                            <div class="card rounded-0 border-black"
                                 v-bind:class="{'border-secondary shadow-lg':item.selected}">
                                <a :href="item.image" target="_blank">
                                    <img
                                        style="min-height: 200px;display: flex; justify-content: center; align-items: center;"
                                        v-lazy="item.image" class="card-img-top object-fit-contain" alt="...">
                                </a>
                                <div class="card-body" v-if="item.title||item.description">
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
                     v-if="(doorForm.handle_holes_type.variants||[]).length===0&&doorForm.need_handle_holes">

                    <div class="alert alert-warning rounded-0 mb-2" role="alert">
                        <p>Вариантов изображений ручки нет</p>
                    </div>
                </div>

                <div class="col-12 d-flex align-items-center">
                    <div class="form-check form-switch ">
                        <input class="form-check-input"
                               v-model="doorForm.need_upper_jumper"
                               type="checkbox" role="switch" id="need-upper-jumper" checked>
                        <label class="form-check-label" for="need-upper-jumper">
                            Нужна верхняя перемычка
                        </label>
                    </div>

                </div>


                <div class="col-12 d-flex align-items-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input"
                               type="checkbox"
                               @change="swapDoorstepStopper(0)"

                               role="switch" id="need-automatic-doorstep" checked>
                        <label class="form-check-label" for="need-automatic-doorstep">
                            Нужен автоматический порог \ не нужен
                        </label>
                    </div>


                </div>


                <div
                    v-if="doorForm.need_automatic_doorstep"
                    class="col-12 d-flex align-items-center">
                    <div class="form-floating w-100 my-3">
                        <select class="form-select"
                                v-model="doorForm.service_doorstep"
                                id="door-service-doorstep" aria-label="Floating label select example">
                            <option :value="service" v-for="service in getServiceByType('service_doorstep')">
                                {{ service.title || '-' }}
                            </option>
                        </select>
                        <label for="door-service-doorstep">Выберите вариант</label>
                    </div>

                </div>

                <div class="col-12 d-flex align-items-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input"
                               type="checkbox" role="switch"
                               @change="swapDoorstepStopper(1)"

                               id="need-hidden-stopper" checked>
                        <label class="form-check-label" for="need-hidden-stopper">
                            Нужен скрытый стопор \ не нужен
                        </label>
                    </div>
                </div>


                <div
                    v-if="doorForm.need_hidden_stopper"
                    class="col-12 d-flex align-items-center">
                    <div class="form-floating w-100 my-3">
                        <select class="form-select"
                                v-model="doorForm.service_stopper"
                                id="door-service-stopper"
                                aria-label="Floating label select example">
                            <option :value="service" v-for="service in getServiceByType('service_stopper')">
                                {{ service.title || '-' }}
                            </option>
                        </select>
                        <label for="door-service-stopper">Выберите вариант</label>
                    </div>

                </div>


                <div class="col-12 d-flex align-items-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input"
                               v-model="doorForm.need_hidden_door_closer"
                               type="checkbox" role="switch" id="need-hidden-door-closer" checked>
                        <label class="form-check-label" for="need-hidden-door-closer">
                            Нужен скрытый доводчик \ не нужен
                        </label>
                    </div>


                </div>

                <div
                    v-if="doorForm.need_hidden_door_closer"
                    class="col-12 d-flex align-items-center">
                    <div class="form-floating w-100 my-3">
                        <select class="form-select"
                                v-model="doorForm.service_door_closer"
                                id="door-service-door_closer"
                                aria-label="Floating label select example">
                            <option :value="service" v-for="service in getServiceByType('service_door_closer')">
                                {{ service.title || '-' }}
                            </option>
                        </select>
                        <label for="door-service-door_closer">Выберите вариант</label>
                    </div>

                </div>

                <div class="col-12 d-flex align-items-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input"
                               v-model="doorForm.need_hidden_skirting_board"
                               type="checkbox" role="switch" id="need-hidden-skirting-board" checked>
                        <label class="form-check-label" for="need-hidden-skirting-board">
                            Нужен скрытый плинтус \ не нужен
                        </label>
                    </div>

                </div>


                <div class="col-12 d-flex align-items-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input"
                               type="checkbox"
                               v-model="doorForm.need_door_install"
                               role="switch" id="need-door-install" checked>
                        <label class="form-check-label" for="need-door-install">
                            Нужна установка двери \ не нужна
                        </label>
                    </div>


                </div>


                <div class="col-12 d-flex align-items-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input"
                               type="checkbox"
                               v-model="doorForm.need_wrapper"
                               role="switch" id="need-door-wrapper" checked>
                        <label class="form-check-label" for="need-door-wrapper">
                            Нужна упаковка двери \ не нужна
                        </label>
                    </div>


                </div>

            </div>


        </div>
        <div class="col-md-6">
            <div class="preview">
                <DoorPreview
                    v-if="loadedParams"
                    v-model="doorForm">
                </DoorPreview>
                <div class="card rounded-0 mt-3">
                    <div class="card-body">
                        <h6>Характеристики </h6>
                        <h6 class="text-muted font-bold">
                            {{ shortDoorTitle }}
                            {{ doorForm.width || 0 }}x{{ doorForm.height || 0 }}x{{ doorForm.opening_type?.depth || 0 }}
                        </h6>
                        <h6 class="text-black mb-0">
                            <span class="mr-1" v-if="doorForm.box_and_frame_color?.title">({{
                                    doorForm.box_and_frame_color.title
                                }}),</span>
                            <span class="mr-1" v-if="doorForm.front_side_finish_color?.title">первая сторона {{
                                    doorForm.front_side_finish_color.title
                                }},</span>
                            <span class="mr-1" v-if="doorForm.back_side_finish_color?.title">/вторая сторона {{
                                    doorForm.back_side_finish_color.title
                                }},</span>
                            <span class="mr-1" v-if="doorForm.loops?.title">петли {{ doorForm.loops.title }}</span>
                            <span class="mr-1" v-if="doorForm.fittings_color?.title">({{
                                    doorForm.fittings_color.title
                                }}),</span>
                            <span class="mr-1" v-if="doorForm.opening_type?.title">{{
                                    doorForm.opening_type.title
                                }},</span>
                            <span class="mr-1" v-if="doorForm.depth">Толщина профиля {{ doorForm.depth }} мм,</span>
                            <span class="mr-1" v-if="doorForm.need_upper_jumper !== 'true'">без верх. перемычки,</span>
                            <span class="mr-1"
                                  v-if="doorForm.need_automatic_doorstep === 'true'">Автоматический порог,</span>
                            <span class="mr-1" v-if="doorForm.need_hidden_stopper === 'true'">Скрытый стопор,</span>
                            <span class="mr-1"
                                  v-if="doorForm.need_hidden_door_closer === 'true'">Скрытый доводчик,</span>
                            <span class="mr-1"
                                  v-if="doorForm.need_hidden_skirting_board === 'true'">Скрытый плинтус,</span>
                            <span class="mr-1" v-if="doorForm.need_door_install === 'true'">Установка двери,</span>
                            <span class="mr-1" v-if="doorForm.need_handle_holes === 'true'">Ручка в комплекте</span>
                        </h6>
                    </div>
                </div>

                <div class="card rounded-0 mt-3" v-if="tmp_prices.length>0">
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                            <tr v-for="item in tmp_prices">
                                <td>{{ type_dictionary[item.type] || item.type }}
                                    <template v-if="doorForm[item.type]">
                                        <br>
                                        <small
                                            v-if="doorForm[item.type].description">({{
                                                doorForm[item.type].description
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


        <div class="col-12 mt-2">
            <div class="row bg-white ">
                <div
                    v-bind:class="{'col-md-2':doorForm.price_type.id===3,'col-md-4':doorForm.price_type.id!==3}">


                    <div class="form-floating">
                        <select class="form-select"
                                v-model="doorForm.price_type"
                                @invalid="alert('Вы не выбрали тип цены!')"
                                id="door-type" aria-label="door-type" required>

                            <option :value="item"
                                    v-for="item in getDictionary.price_type_variants">{{
                                    item.title
                                }}
                            </option>
                        </select>
                        <label for="door-type">Тип цены</label>
                    </div>
                </div>
                <div class="col-md-2"
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
                <div class="col-md-4 d-flex justify-between">
                    <button type="button"
                            @click="changeDoorCount('sub')"
                            class="btn btn-dark rounded-0 mr-2 px-3">
                        <i class="fa-solid fa-minus"></i>
                    </button>
                    <div class="input-group">
                        <input type="number"
                               @invalid="alert('Вы не указали количество дверей')"
                               v-model="doorForm.count"
                               min="1" value="1" class="form-control rounded-0 text-center">
                    </div>

                    <button type="button"
                            @click="changeDoorCount('add')"
                            class="btn btn-dark rounded-0 ml-2 px-3">
                        <i class="fa-solid fa-plus"></i>
                    </button>

                </div>
                <div class="col-md-2 d-flex justify-center align-items-center">
                    <p class="text-center text-primary font-bold text-black" style="font-size: 16px;">
                        {{ resultPrice }}х{{ doorForm.count }}={{ resultPrice * doorForm.count }}₽</p>
                </div>
                <div class="col-md-2 d-flex">
                    <button
                        :disabled="!doorForm.price_type.key"
                        class="btn btn-dark rounded-0 w-100"><i class="fa-solid fa-floppy-disk"></i> Сохранить
                    </button>
                </div>
            </div>
        </div>
        <div class="col-12">

            <div
                @click="removeMessage(index)"
                v-if="messages.length>0"
                v-for="(message, index) in messages"
                class="alert alert-danger alert-dismissible fade show my-2" role="alert">
                <strong>Внимание!</strong> {{ message || 'Ошибка' }}
            </div>

        </div>

    </form>

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
    <div class="modal fade  " id="editor-confirm-dialog-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">

                <div class="modal-body">
                    <div class="d-flex justify-center p-3">
                        <img src="/images/logo.png" style="width: 100px;" alt="">
                    </div>
                    <h3 class="font-bold text-center py-3">{{ confirm.title || '-' }}</h3>
                    <p class="text-center pb-3">{{ confirm.message || '-' }}</p>
                    <div class="row">
                        <div class="col-6">
                            <button class="btn btn-dark rounded-0 w-100" type="button" @click="clearForm">Да,
                                очистить
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-secondary rounded-0 w-100" @click="confirmModal.hide()">Нет,
                                не очищать
                            </button>
                        </div>
                    </div>
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

    <!-- Modal -->
    <div class="modal fade" id="show-current-handle-details" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Просмотр деталей</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <template v-if="selectedHandle">
                        <HandleDetail :selected-handle="selectedHandle">
                        </HandleDetail>
                    </template>


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
    props: ['door', 'editOrder'],
    data() {
        return {
            loaded: false,
            selectedHandle: null,

            type_dictionary: {
                size: 'Петли',
                handle_holes_type: 'Ручка',
                handle_wrapper_type: 'Завертка',
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
                service_handle: 'Услуги по монтажу ручки',
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
                handle_wrapper_type: {title: null}, //тип завертки
                need_handle_holes: true, //нужна дверная ручка
                need_upper_jumper: true, //Верхняя перемычка
                need_automatic_doorstep: false, //Автоматический порог
                need_hidden_stopper: false, //Скрытый стопор
                need_hidden_door_closer: false, //Скрытый доводчик
                need_hidden_skirting_board: false, //нужен плинтус
                need_door_install: false, //нужна установка двери
                need_wrapper: true, //нужна упаковка двери

                service_doorstep: {title: null}, //работа с порогом
                service_painting: {title: null}, //покраска фурнитуры
                service_stopper: {title: null}, //работа со стопером
                service_door_closer: {title: null}, //работа с доводчиком
                service_handle: {title: null}, //работа с ручками
            }
        }
    },
    computed: {
        ...mapGetters(['getErrors', 'getDictionary', 'cartTotalCount', 'cartProducts', 'cartTotalPrice']),
        resultPrice() {
            return (this.doorForm.price_type.id !== 3) ? this.summaryPrice : this.summaryPriceWithDealer
        },
        summaryPriceWithDealer() {
            return Math.round((this.summaryPrice || 0) * (1 + ((this.doorForm.dealer_percent || 0) / 100)))
        },
        shortDoorTitle() {
            let key = this.doorForm.door_type?.title || 'КДС'
            const abbreviations = {
                "Комплект двери скрытого монтажа": "КДС",
            };

            return abbreviations[key] || key;
        },
        summaryPrice() {
            let sum = 0;

            let base = null

            this.tmp_prices = []

            let type = this.doorForm.price_type.key

            Object.keys(this.doorForm).forEach(item => {

                let find = false
                if (item) {

                    if (typeof this.doorForm[item] === "object"
                        && this.doorForm[item] != null
                        && item !== "door_type"
                    ) {
                        if (item === "opening_type" && this.doorForm[item].sizes) {
                            find = true
                            let index = this.doorForm[item].sizes.findIndex(c =>
                                c.width == this.doorForm.width &&
                                c.height == this.doorForm.height)

                            let price = index === -1 ? 0 : this.doorForm[item].sizes[index].price[type]
                            sum += parseInt(price || 0)

                            console.log("opening_type", price, item)
                            this.tmp_prices.push({
                                type: item,
                                price: price
                            })
                        }

                        if (item.indexOf("_color") !== -1 && this.doorForm[item].sizes && !find) {
                            find = true

                            let isExcluded = (this.doorForm[item] || {excludes: []})
                                .excludes.indexOf(item
                                    .substring(0, item
                                        .indexOf("_color"))) !== -1

                            let price = 0;
                            if (!this.doorForm[item].assign_with_size)
                                price = isExcluded ? 0 : this.doorForm[item].sizes[0].price[type]
                            else {
                                let index = this.doorForm[item].sizes.findIndex(c =>
                                    c.width == this.doorForm.width &&
                                    c.height == this.doorForm.height)

                                price = index === -1 || isExcluded ? 0 : this.doorForm[item].sizes[index].price[type]
                            }

                            sum += parseInt(price || 0)

                            this.tmp_prices.push({
                                type: item,
                                price: price
                            })
                        }

                        if (item === "hinge_manufacturer" && this.doorForm[item].title != null && !find) {
                            find = true

                            let price = this.doorForm[item].price[type]
                            let fullPrice = 0

                            if (this.doorForm.size)
                                fullPrice = this.doorForm.size.loops.count * price

                            sum += parseInt(fullPrice || 0)

                            this.tmp_prices.push({
                                type: item,
                                price: price,
                                full_price: fullPrice
                            })
                        }

                        if (item === "size" && this.doorForm[item].loops.price && !find) {
                            find = true
                            let price = this.doorForm[item].loops.price[type]
                            sum += parseInt(price || 0)


                            this.tmp_prices.push({
                                type: item,
                                price: price
                            })
                        }


                        if (item === "service_painting" && this.doorForm[item].title != null && !find) {
                            find = true

                            let price = this.doorForm["fittings_color"].is_ral ? this.doorForm[item].price[type] : 0
                            let fullPrice = 0

                            if (this.doorForm.size)
                                fullPrice = (this.doorForm.size.loops.count + 1) * price

                            sum += fullPrice || 0

                            this.tmp_prices.push({
                                type: item,
                                price: price,
                                full_price: fullPrice
                            })
                        }


                        if (this.doorForm[item].price && !find) {

                            let price = (typeof this.doorForm[item].price === "object") ?
                                (this.doorForm[item].price[type] || 0) :
                                (this.doorForm[item].price || 0)

                            sum += parseInt(price || 0)

                            this.tmp_prices.push({
                                type: item,
                                price: price
                            })
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

            let doorTypeFunc = (tmpBasePrice) => {
                let tmpDoorTypePrice = typeof this.doorForm["door_type"].price === "object" ?
                    this.doorForm["door_type"].price[type] :
                    this.doorForm["door_type"].price

                let koef = this.doorForm["door_type"].id !== 3 ? 1 : 0.8
                let price = this.doorForm["door_type"].need_percent_price ?
                    (tmpBasePrice * tmpDoorTypePrice) / 100 : (tmpBasePrice * koef + tmpDoorTypePrice)

                this.tmp_prices.push({
                    type: "door_type",
                    price: (price || 0) > 0 ? price : tmpBasePrice
                })

                return (price || 0) > 0 ? price : tmpBasePrice
            }

            if (find) {
                base = section.materials.find(m => m.is_base) || {
                    price: {
                        wholesale: 0,
                        dealer: 0,
                        retail: 0,
                        cost: 0,
                    }
                }

                let tmpBasePrice = typeof base.price === "object" ? base.price[type] : base.price

                this.tmp_prices.push({
                    type: 'base',
                    price: tmpBasePrice
                })

                price = parseInt(doorTypeFunc(tmpBasePrice))

                //sum += parseInt(doorTypeFunc(tmpBasePrice))

                section.materials.forEach(sub => {
                    if (sub.id === this.doorForm.front_side_finish.id
                        && !this.doorForm.front_side_finish.is_base
                    ) {
                        let tmpPrice = typeof sub.price === "object" ? sub.price[type] : sub.price
                        price += tmpPrice

                        this.tmp_prices.push({
                            type: 'front_side_finish',
                            price: tmpPrice
                        })
                    }

                    if (sub.id === this.doorForm.back_side_finish.id
                        && !this.doorForm.back_side_finish.is_base
                    ) {
                        let tmpPrice = typeof sub.price === "object" ? sub.price[type] : sub.price
                        price += tmpPrice

                        this.tmp_prices.push({
                            type: 'back_side_finish',
                            price: tmpPrice
                        })
                    }

                })


            } else {

                for (let i = 0; i < basePrices.length; i++) {
                    if (basePrices[i].width >= this.doorForm.width && basePrices[i].height >= this.doorForm.height) {

                        base = basePrices[i].materials.find(m => m.is_base) || {
                            price: {
                                wholesale: 0,
                                dealer: 0,
                                retail: 0,
                                cost: 0,
                            }
                        }

                        let tmpBasePrice = typeof base.price === "object" ? base.price[type] : base.price

                        this.tmp_prices.push({
                            type: 'base',
                            price: tmpBasePrice
                        })


                        price = parseInt(doorTypeFunc(tmpBasePrice))


                        //  sum += parseInt(doorTypeFunc(tmpBasePrice))

                        basePrices[i].materials.forEach(sub => {
                            if (sub.id === this.doorForm.front_side_finish.id
                                && !this.doorForm.front_side_finish.is_base
                            ) {


                                let tmpPrice = typeof sub.price === "object" ? sub.price[type] : sub.price
                                price += tmpPrice
                                this.tmp_prices.push({
                                    type: 'front_side_finish',
                                    price: tmpPrice
                                })
                            }

                        })

                        basePrices[i].materials.forEach(sub => {
                            if (sub.id === this.doorForm.back_side_finish.id
                                && !this.doorForm.back_side_finish.is_base
                            ) {

                                let tmpPrice = typeof sub.price === "object" ? sub.price[type] : sub.price
                                price += tmpPrice
                                this.tmp_prices.push({
                                    type: 'back_side_finish',
                                    price: tmpPrice
                                })
                            }

                        })
                        break;
                    }
                }
            }

            let intRound = (arg) => {
                return Math.round(parseInt(arg) / 10) * 10;
            }


            return intRound(sum + price);//this.doorForm.dealer_percent > 0 ? (sum + price) * (1 + (this.doorForm.dealer_percent / 100)) : sum + price;
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

        'doorForm': {
            handler(val) {
                console.log("doorForm", this.doorForm)
                this.loadedParams = false
                this.$nextTick(() => {
                    this.loadedParams = true
                })

            },
            deep: true
        },


        'doorForm.fittings_color': {
            handler(val) {
                if (this.doorForm.fittings_color.title == null) {
                    this.doorForm.service_painting = {title: null}
                } else {
                    let services = this.getServiceByType("service_painting")
                    this.doorForm.service_painting = services.length > 0 ? services[0] : {title: null}
                }

            },
            deep: true
        },
        'doorForm.need_hidden_stopper': {
            handler(val) {
                if (!this.doorForm.need_hidden_stopper) {
                    this.doorForm.service_stopper = {title: null}
                } else {
                    let services = this.getServiceByType("service_stopper")
                    this.doorForm.service_stopper = services.length > 0 ? services[0] : {title: null}
                }

            },
            deep: true
        },
        'doorForm.need_hidden_door_closer': {
            handler(val) {
                if (!this.doorForm.need_hidden_door_closer) {
                    this.doorForm.service_door_closer = {title: null}
                } else {
                    let services = this.getServiceByType("service_door_closer")
                    this.doorForm.service_door_closer = services.length > 0 ? services[0] : {title: null}
                }

            },
            deep: true
        },
        'doorForm.need_automatic_doorstep': {
            handler(val) {
                if (!this.doorForm.need_automatic_doorstep) {
                    this.doorForm.service_doorstep = {title: null}
                } else {
                    let services = this.getServiceByType("service_doorstep")
                    this.doorForm.service_doorstep = services.length > 0 ? services[0] : {title: null}
                }

            },
            deep: true
        },

        'doorForm.need_handle_holes': {
            handler(val) {
                if (!this.doorForm.need_handle_holes) {
                    this.doorForm.handle_holes = this.getDictionary.handle_holes_variants[0]
                    this.doorForm.handle_holes_type = {title: null}
                    this.doorForm.handle_wrapper_type = {title: null}
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

                let base = this.tmp_prices.find(item => item.type === 'door_type')?.price || 0

                //if (this.doorForm.price_type.id !== 3)
                this.doorForm.price = this.summaryPrice
                this.doorForm.base_price = base

            },
            deep: true
        }
    },

    mounted() {
        this.detailsModal = new bootstrap.Modal(document.getElementById('show-current-handle-details'), {})
        //this.loadRalColors()

        window.addEventListener("clear-cart", (e) => {
            this.$store.dispatch("loadFormattedSizes").then(resp => {
                this.clearForm()
                this.loaded = true
            }).catch(() => {

            })
        });

        this.confirmModal = new bootstrap.Modal(document.getElementById('editor-confirm-dialog-modal'), {})

        if (!this.door) {
            this.$store.dispatch("loadFormattedSizes").then(resp => {
                this.clearForm()
                this.loaded = true
            }).catch(() => {

            })
        } else {
            this.$store.dispatch("loadFormattedSizes").then(resp => {
                this.loaded = false
                this.$nextTick(() => {

                    let door = this.door.product ? this.door.product : this.door.door

                    console.log(door)

                    this.doorForm.id = this.editOrder ? this.door.id : this.door.product.id


                    this.doorForm.width = door.width
                    this.doorForm.height = door.height
                    this.doorForm.depth = door.depth
                    this.doorForm.count = this.editOrder ? this.door.count : door.quantity
                    this.doorForm.size = door.size
                    this.doorForm.purpose = door.purpose || "Входная"
                    this.doorForm.handle_holes = door.handle_holes || {title: null}
                    this.doorForm.handle_holes_type = door.handle_holes_type || {title: null}
                    this.doorForm.handle_wrapper_type = door.handle_wrapper_type || {title: null}
                    this.doorForm.opening_type = door.opening_type || {title: null}
                    this.doorForm.box_and_frame_color = door.box_and_frame_color || {title: null}
                    this.doorForm.door_type = door.door_type || {title: null}
                    this.doorForm.front_side_finish = door.front_side_finish || {title: null}
                    this.doorForm.back_side_finish = door.back_side_finish || {title: null}
                    this.doorForm.front_side_finish_color = door.front_side_finish_color || {title: null}
                    this.doorForm.back_side_finish_color = door.back_side_finish_color || {title: null}
                    this.doorForm.seal_color = door.seal_color || {title: null}
                    this.doorForm.fittings_color = door.fittings_color || {title: null}
                    this.doorForm.loops = door.loops || {title: null}
                    this.doorForm.loops_count = door.loops_count || 0
                    this.doorForm.price_type = door.price_type || {title: null}
                    this.doorForm.hinge_manufacturer = door.hinge_manufacturer || {title: null}
                    this.doorForm.need_handle_holes = door.need_handle_holes || true
                    this.doorForm.need_upper_jumper = door.need_upper_jumper || true
                    this.doorForm.need_automatic_doorstep = door.need_automatic_doorstep || false
                    this.doorForm.need_hidden_stopper = door.need_hidden_stopper || false
                    this.doorForm.need_hidden_door_closer = door.need_hidden_door_closer || false
                    this.doorForm.need_hidden_skirting_board = door.need_hidden_skirting_board || false
                    this.doorForm.need_door_install = door.need_door_install || false
                    this.doorForm.need_wrapper = door.need_wrapper || true
                    this.doorForm.service_doorstep = door.service_doorstep || {title: null}
                    this.doorForm.service_painting = door.service_painting || {title: null}
                    this.doorForm.service_stopper = door.service_stopper || {title: null}
                    this.doorForm.service_door_closer = door.service_door_closer || {title: null}
                    this.doorForm.service_handle = door.service_handle || {title: null}


                    this.loaded = true
                })


            }).catch(() => {


            })


        }


    },
    methods: {
        showDetails(item) {
            this.selectedHandle = null

            this.$nextTick(() => {
                this.selectedHandle = item
                this.detailsModal.show()
            })


        },
        loadRalColors() {
            this.$store.dispatch("loadRalColors")
        },
        openConfirmModal(title, message) {
            this.confirm.title = title || null
            this.confirm.message = message || null

            this.confirmModal.show()
        },

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

            if (!section)
                return price;

            let tmp = null
            if (section.materials)
                section.materials.forEach(sub => {
                    if (sub.id === this.doorForm[param].id) {
                        tmp = sub.price
                        price = typeof sub.price === "object" ? sub.price[type] : sub.price
                    }

                })

            //this.doorForm[param].price = tmp

            return price
        },

        clearForm() {

            this.loaded = false
            this.confirmModal.hide()

            this.$nextTick(() => {
                const doorForm = {
                    purpose: "Дверь " + (this.cartProducts.length + 1),
                    id: uuid.v1(),
                    count: 1,
                    width: this.getDictionary.size_variants[0].width,
                    height: this.getDictionary.size_variants[0].height,
                    size: this.getDictionary.size_variants[0],
                    loops_count: this.getDictionary.size_variants[0].loops.count,
                    handle_holes: this.getDictionary.handle_holes_variants[0],
                    handle_holes_type: {title: null},
                    handle_wrapper_type: {title: null},
                    opening_type: this.getDictionary.opening_variants[0],
                    box_and_frame_color: {title: null},
                    door_type: this.getDictionary.door_variants[0],
                    front_side_finish: this.getDictionary.finishes_variants[0],
                    back_side_finish: this.getDictionary.finishes_variants[0],
                    front_side_finish_color: {title: null},
                    back_side_finish_color: {title: null},
                    seal_color: {title: null},
                    fittings_color: {title: null},
                    loops: this.getDictionary.loops_variants[0],
                    price_type: this.getDictionary.price_type_variants[0],
                    hinge_manufacturer: this.getDictionary.hinge_manufacturer_variants[0],
                    need_handle_holes: true,
                    need_upper_jumper: true,
                    need_automatic_doorstep: false,
                    need_hidden_stopper: false,
                    need_hidden_door_closer: false,
                    need_hidden_skirting_board: false,
                    need_door_install: false,
                    need_wrapper: true,
                    service_doorstep: {title: null},
                    service_painting: {title: null},
                    service_stopper: {title: null},
                    service_door_closer: {title: null},
                    service_handle: {title: null},
                }


                this.doorForm = doorForm

                if (this.cartTotalCount > 0) {
                    const handle = JSON.parse(localStorage.getItem("dodoors_handle_holes_type_selected"))
                    console.log("handle for selection", handle)
                    if (handle)
                        this.doorForm.handle_holes_type = handle
                }


                this.loaded = true
            })

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

            this.doorForm.loops_count = item.loops.count
            // this.doorForm.loops = item.loops.count
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
        swapDoorstepStopper(index) {
            this.doorForm.need_automatic_doorstep = index === 0 && this.doorForm.need_automatic_doorstep
            this.doorForm.need_hidden_stopper =  index === 1 && this.doorForm.need_hidden_stopper
        },
        getServiceByType(type) {
            if ((this.getDictionary.services || []).length === 0)
                return []

            let services = this.getDictionary.services.filter(item => item.type === type && item.is_active)

            return services.length > 0 ? services.sort((a, b) => {
                return b.order_position - a.order_position
            }) : []
        },
        alert(msg) {
            this.messages.push(msg)
        },
        removeMessage(index) {
            this.messages.splice(index, 1)
        },
        syncColors(name, color) {

            if (color.title == 'RAL')
                return;

            const variants = [
                {
                    color: 'Silver',
                    box_and_frame_color: {
                        title: 'Серебро',
                        code: '#c0c0c0',
                    },
                    seal_color: {
                        title: 'Серый',
                        code: '#808080'
                    },
                    fittings_color: {
                        title: 'Серебро',
                        code: '#c0c0c0',
                    },
                },
                {
                    color: 'Black',
                    box_and_frame_color: {
                        title: 'Черный',
                        code: '#000000',
                    },
                    seal_color: {
                        title: 'Черный',
                        code: '#000000',
                    },
                    fittings_color: {
                        title: 'Черный',
                        code: '#000000',
                    },
                },
                {
                    color: 'Gold',
                    box_and_frame_color: {
                        title: 'Золотой',
                        code: '#ffd700',
                    },
                    seal_color: {
                        title: 'Бежевый',
                        code: '#f5f5dc',
                    },
                    fittings_color: {
                        title: 'Золотой',
                        code: '#ffd700',
                    },
                }
            ]


            this.color_sync_update = true
            this.$nextTick(() => {
                this.color_sync_update = false

                let selected = variants.find(v => v.color === color.title);

                this.doorForm.box_and_frame_color = {
                    assign_with_size: color.assign_with_size,
                    code: selected ? selected.box_and_frame_color.code : color.code,
                    title: selected ? selected.box_and_frame_color.title : color.title,
                    excludes: color.excludes,
                    is_ral: color.is_ral,
                    sizes: color.sizes,
                    type: color.type
                }

                this.doorForm.seal_color = {
                    assign_with_size: color.assign_with_size,
                    code: selected ? selected.seal_color.code : color.code,
                    title: selected ? selected.seal_color.title : color.title,
                    excludes: color.excludes,
                    is_ral: color.is_ral,
                    sizes: color.sizes,
                    type: color.type
                }

                this.doorForm.fittings_color = {
                    assign_with_size: color.assign_with_size,
                    code: selected ? selected.fittings_color.code : color.code,
                    title: selected ? selected.fittings_color.title : color.title,
                    excludes: color.excludes,
                    is_ral: color.is_ral,
                    sizes: color.sizes,
                    type: color.type
                }


            })


        },
        submitForm() {
            this.messages = []

            if (this.editOrder) {
                let data = new FormData();
                Object.keys(this.doorForm)
                    .forEach(key => {
                        const item = this.doorForm[key] || ''
                        if (typeof item === 'object')
                            data.append(key, JSON.stringify(item))
                        else
                            data.append(key, item)
                    });


                this.$store.dispatch("editDoorInOrder", {
                    doorForm: data
                }).then((response) => {
                    this.$emit("callback")
                    this.resetForm()
                }).catch(error => {

                })
                return;
            }

            this.$store.dispatch("addProductToCart", {
                product: this.doorForm,
                price: this.summaryPrice
            }).then(() => {

                this.confirm.title = "Товар успешно добавлен в корзину"
                this.confirm.message = "Очистить форму?"
                this.confirmModal.show()


                this.$notify({
                    title: "DoDoors",
                    text: "Дверь успешно добавлена в корзину",
                    type: "success"
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
