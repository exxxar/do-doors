<template>

    <div class="row" v-if="door">
        <div class="col-12 mb-2">
            <button class="btn mr-2 rounded-0 "
                    v-bind:class="{'btn-dark':side===0,'btn-outline-secondary':side!==0}"
                    @click="side=0"> Лицевая сторона
            </button>

            <button class="btn rounded-0"
                    v-bind:class="{'btn-dark':side===1,'btn-outline-secondary':side!==1}"
                    @click="side=1"> Внутренняя сторона
            </button>
        </div>

    </div>
    <div class="row" v-if="door">
        <div class="col-12 col-md-8">
            <div class="stage w-100"
                 v-bind:style="{/*'background-color':sideColor || 'transparent',*/ 'background-image':'url('+selectedSideFinishImageForWrapper+')'}">
                <div class="upper-jumper d-flex justify-content-center align-items-center"
                     v-if="door.need_upper_jumper">
                    <div class="door-upper-jumper d-flex justify-content-center align-items-center">
                        <p class="text-center" style="font-size: 12px;">1</p>
                    </div>
                </div>


                <div style="position: relative;">
                    <div class="door">
                        <img :src="doorImage?doorImage:'/images/door-1.jpg'"
                             class="w-100 h-100" style="object-fit: cover;"
                             alt="">
                        <div class="door-color" v-bind:style="{'background-color':sideColor || 'transparent'}"></div>
                        <div class="height"><span>{{ door.height }}</span></div>
                        <div class="width"><span>{{ door.width }}</span></div>
                        <div class="handle"
                             style="background-size: cover;"
                             v-bind:class="{'to-left':door.loops.type==='left','to-right':door.loops.type==='right'}"
                             v-bind:style="{'background-color':door.handle_holes_type.color || 'transparent','background-image':door.loops.type==='right'?'url(images/handle-left.png)':'url(images/handle-right.png)'}"
                             v-if="door.handle_holes.id!==3&&door.need_handle_holes&&door.loops.type">6
                        </div>
                        <div class="loops"
                             v-if="door.loops.type"
                             v-bind:class="{'to-left':door.loops.type==='left','to-right':door.loops.type==='right'}">
                            <span v-for="loop in door.loops_count">7</span>
                        </div>
                    </div>

                    <div class="door-but">
                        <div class="height"><span>{{ door.height }}</span></div>
                        <div class="depth"><span>{{ door.depth }}</span></div>
                    </div>
                </div>


                <div class="door-footer">
                    <div class="doorstep d-flex justify-content-center align-items-center"
                         style="font-size: 12px;"
                         v-if="door.need_automatic_doorstep">
                        2
                    </div>
                    <div class="skirting-board d-flex justify-content-center align-items-center"
                         style="font-size: 12px;"
                         v-if="door.need_hidden_skirting_board">
                        <p>3</p>
                    </div>

                    <div class="stopper d-flex justify-content-center align-items-center"
                         style="font-size: 12px;"
                         v-bind:class="{'to-left':door.loops.type==='left','to-right':door.loops.type==='right'}"
                         v-if="door.need_hidden_stopper">
                        4
                    </div>

                    <div
                        class="door-closer d-flex justify-content-center align-items-center"
                         style="font-size: 12px;"
                         v-bind:class="{'to-left':door.loops.type==='left','to-right':door.loops.type==='right'}"
                         v-if="door.need_hidden_door_closer">
                        5
                    </div>


                </div>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <ul class="list-group list-group-numbered rounded-0 cursor-pointer">
                <li
                    @click="door.need_upper_jumper=!door.need_upper_jumper"
                    v-bind:class="{'bg-dark text-white':door.need_upper_jumper}"
                    class="list-group-item">Верхняя перемычка</li>
                <li
                    @click="door.need_automatic_doorstep=!door.need_automatic_doorstep"
                    v-bind:class="{'bg-dark text-white':door.need_automatic_doorstep}"
                    class="list-group-item">Скрытый порог</li>
                <li
                    @click="door.need_hidden_skirting_board=!door.need_hidden_skirting_board"
                    v-bind:class="{'bg-dark text-white':door.need_hidden_skirting_board}"
                    class="list-group-item">Скрытый плинтус</li>
                <li
                    @click="door.need_hidden_stopper=!door.need_hidden_stopper"
                    v-bind:class="{'bg-dark text-white':door.need_hidden_stopper}"
                    class="list-group-item">Скрытый стопор</li>
                <li
                    @click="door.need_hidden_door_closer=!door.need_hidden_door_closer"
                    v-bind:class="{'bg-dark text-white':door.need_hidden_door_closer}"
                    class="list-group-item">Скрытый доводчик</li>
                <li
                    @click="door.need_handle_holes=!door.need_handle_holes"
                    v-bind:class="{'bg-dark text-white':door.need_handle_holes&&door.loops.type}"
                    class="list-group-item">Дверная ручка</li>
                <li class="list-group-item">Петли</li>

            </ul>


        </div>

    </div>


</template>
<script>
export default {
    props: ["modelValue"],
    data() {
        return {
            side: 0,
            door:null
        }
    },
    watch: {
        'door': {
            handler(val){
                this.$emit('update:modelValue', this.door)
            },
            deep: true
        }
    },
    mounted() {
      this.door = this.modelValue
    },
    computed: {
        sideColor() {
            return this.side === 0 ? this.door.front_side_finish_color.code : this.door.back_side_finish_color.code
        },
        selectedSideFinishImageForDoor() {
            let param = this.side === 0 ? "front_side_finish" : "back_side_finish"

            if (!this.door[param].door_variants)
                return null

            let index = this.door[param].door_variants.findIndex(item => item.selected)


            if (index === -1)
                return null;
            return this.door[param].door_variants[index].image
        },
        selectedSideFinishImageForWrapper() {
            let param = this.side === 0 ? "front_side_finish" : "back_side_finish"

            if (!this.door[param].wrapper_variants)
                return null

            let index = this.door[param].wrapper_variants.findIndex(item => item.selected)


            if (index === -1)
                return null;
            return this.door[param].wrapper_variants[index].image
        }
    },
}
</script>
<style lang="scss">
.stage {
    width: 100%;
    min-height: 400px;
    max-height: 500px;
    display: flex;
    justify-content: end;
    align-items: center;
    position: relative;
    background-color: white;
    border: 1px dashed black;
    /* display: flex; */
    flex-direction: column;

    .upper-jumper {
        width: 100%;
        height: 20px;
        position: relative;
        border-bottom: 1px dashed black;

        .door-upper-jumper {

            height: 100%;
            width: 200px;
            background-image: repeating-linear-gradient(
                    -45deg,
                    #3f0909 0,
                    #3f0909 15px,
                    #ffffff 15px,
                    #ffffff 25px
            );
            p {
                display: inline-block;
                width: 40px;
                text-align: center;
                font-weight: bold;
                color: black;
                background-color: rgba(255, 255, 255, 0.7);
            }
        }
    }


    .door-footer {
        width: 100%;
        height: 40px;
        position: relative;
        border-top: 1px dashed black;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;

        .doorstep {
            position: absolute;
            width: 200px;
            height: 22px;
            background-color: #fdfdfd;
            border: 1px dashed black;
            background-image: repeating-linear-gradient(
                    -45deg,
                    #e3e3e3 0,
                    #e3e3e3 15px,
                    #ffffff 15px,
                    #ffffff 25px
            );
        }

        .skirting-board {
            position: absolute;
            width: 100%;
            height: 18px;
            bottom: 0px;
            border-top: 1px dashed black;

            z-index: 2;
            background-image: repeating-linear-gradient(
                    -45deg,
                    #651111 0,
                    #651111 15px,
                    #ffffff 15px,
                    #ffffff 25px
            );

            p {
                display: inline-block;
                background-color: rgba(255, 255, 255, 0.7);
                width: 40px;
                text-align: center;
                font-weight: bold;
                color: black;
            }
        }

        .stopper {
            position: absolute;
            width: 18px;
            height: 18px;
            top: -18px;

            border: 1px dashed black;
            z-index: 2;

            &.to-left {
                margin-left: 150px;
            }

            &.to-right {
                margin-right: 150px;
            }
        }

        .door-closer {
            position: absolute;
            width: 50px;
            height: 18px;
            top: -18px;
            margin-right: 150px;
            border: 1px dashed black;
            z-index: 2;

            &.to-left {
                margin-right: 150px;
            }

            &.to-right {
                margin-right: -150px;
            }
        }
    }

    .door-but {
        width: 40px;
        height: 400px;
        background-size: cover;
        position: absolute;
        right: -90px;
        top: 0;
        border: 1px black solid;

        background-image: repeating-linear-gradient(
                -45deg,
                #eeeeee 0,
                #eeeeee 15px,
                #ffffff 15px,
                #ffffff 25px
        );

        .height {
            position: absolute;
            top: 0;
            left: -25px;
            width: 20px;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;

            &:after {
                content: '';
                width: 1px;
                height: 100%;
                background-color: #5d4e4e;
                position: absolute;
                z-index: 1;
            }

            span {
                transform: rotate(270deg);
                background-color: white;
                z-index: 2;
                position: absolute;
            }

        }

        .depth {
            position: absolute;
            left: 0;
            top: 25px;
            width: 100%;
            height: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;

            &:after {
                content: "";
                width: 100%;
                height: 1px;
                background-color: #5d4e4e;
                position: absolute;
                z-index: 1;
            }

            span {
                background-color: white;
                z-index: 2;
                position: absolute;

            }

        }

    }

    .door {
        width: 200px;
        height: 400px;
        //  background: url('/images/door-1.jpg');
        background-size: cover;
        position: relative;

        .height {
            position: absolute;
            top: 0;
            left: -25px;
            width: 20px;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;

            &:after {
                content: '';
                width: 1px;
                height: 100%;
                background-color: #5d4e4e;
                position: absolute;
                z-index: 1;
            }

            span {
                transform: rotate(270deg);
                background-color: white;
                z-index: 2;
                position: absolute;
            }

        }

        .width {
            position: absolute;
            left: 0;
            top: 25px;
            width: 100%;
            height: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;

            &:after {
                content: "";
                width: 100%;
                height: 1px;
                background-color: #5d4e4e;
                position: absolute;
                z-index: 1;
            }

            span {
                background-color: white;
                z-index: 2;
                position: absolute;

            }

        }

        .door-color {
            position: absolute;
            z-index: 1;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            opacity: 50%;
        }

        .loops {
            position: absolute;
            z-index: 3;
            width: 20px;
            height: 100%;
            top: 0px;

            border: 1px dashed black;
            text-align: center;
            line-height: 120%;

            display: flex;
            flex-direction: column;
            justify-content: space-around;

            &.to-left {
                left: 0;
            }

            &.to-right {
                right: 0;
            }

            span {
                width: 20px;
                height: 30px;
                border: 1px dashed black;

                display: flex;
                justify-content: center;
                align-items: center;
            }
        }

        .handle {
            position: absolute;
            z-index: 3;
            width: 50px;
            height: 27px;
            top: 209px;

            border: 1px dashed black;
            text-align: center;
            line-height: 120%;


            &.to-left {
                right: 25px;
            }

            &.to-right {

                left: 25px;
            }

        }
    }
}

.door-image {
    max-width: 200px;

    img {
        object-fit: cover;
    }
}

.door-wrapper {
    width: 500px;
    min-height: 589px;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: end;
    background: #f1e1df;

    .back-image {
        top: 0px;
        left: 0px;
        position: absolute;
        object-fit: cover;
        z-index: 0;
    }

    .front-image {
        position: absolute;
        object-fit: cover;
        z-index: 1;
    }
}


.preview {
    position: sticky;
    top: 10px;
}
</style>
