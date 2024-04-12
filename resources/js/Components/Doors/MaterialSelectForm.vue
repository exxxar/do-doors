
<template>
    <h3 class="font-bold my-2">Выбранный материал "{{ item.title || 'не указан' }}"</h3>

    <div class="row">
        <div class="col-12">
            <div class="form-check form-switch">
                <input class="form-check-input"
                       v-model="need_select_door_variant"
                       type="checkbox" role="switch" id="need_select_door_variant" checked>
                <label class="form-check-label" for="need_select_door_variant">
                    Нужно подобрать текстуру дверей
                </label>
            </div>
        </div>
    </div>

    <div class="row mb-2" v-if="item.door_variants&&need_select_door_variant">
        <div class="col-12">

            <h6 class="font-700 font-bold my-3">Перечень вариантов дверей</h6>
        </div>
        <div class="col-lg-4 col-md-4 col-12 mb-2"
             v-for="(door, index) in item.door_variants">
            <div class="card cursor-pointer"
                 v-bind:class="{'border-secondary shadow-lg':door.selected}"
                 @click="selectSideFinish('door_variants',index)">
                <img v-lazy="door.image" class="card-img-top" alt="...">
                <div class="card-body">
                    <h6 class="font-bold" v-if="door.title">{{ door.title || 'не указано' }}</h6>
                    <p class="card-text" v-if="door.description">{{
                            door.description || 'не указано'
                        }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="form-check form-switch">
                <input class="form-check-input"
                       v-model="need_select_wrapper_variant"
                       type="checkbox" role="switch" id="need_select_door_variant" checked>
                <label class="form-check-label" for="need_select_door_variant">
                    Нужно подобрать текстуру материала вокруг двери
                </label>
            </div>
        </div>
    </div>

    <div class="row mb-2" v-if="item.wrapper_variants&&need_select_wrapper_variant">
        <div class="col-12">
            <h6 class="font-700 font-bold my-3">Перечень вариантов текстуры материала вокруг дверей</h6>
        </div>


        <div class="col-lg-4 col-md-4 col-12 mb-2"
             v-for="(door, index) in item.wrapper_variants">
            <div class="card cursor-pointer"
                 v-bind:class="{'border-secondary shadow-lg':door.selected}"
                 @click="selectSideFinish('wrapper_variants',index)">
                <img v-lazy="door.image" class="card-img-top" alt="...">
                <div class="card-body">
                    <h6 class="font-bold" v-if="door.title">{{ door.title || 'не указано' }}</h6>
                    <p class="card-text" v-if="door.description">{{
                            door.description || 'не указано'
                        }}</p>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
export default {
    props: ["item"],
    data() {
        return {
            need_select_door_variant: true,
            need_select_wrapper_variant: true,
        }
    },
    watch: {

        'need_select_door_variant': {
            handler(val) {
                if (!this.need_select_door_variant) {
                    this.item["door_variants"].forEach(item => {
                        if (item.selected)
                            delete item.selected
                    })

                    this.$emit("update:item", this.item)
                }

            },
            deep: true
        },

        'need_select_wrapper_variant': {
            handler(val) {
                if (!this.need_select_wrapper_variant) {
                    this.item["wrapper_variants"].forEach(item => {
                        if (item.selected)
                            delete item.selected
                    })

                    this.$emit("update:item", this.item)
                }


            },
            deep: true
        },
    },
    methods: {

        selectSideFinish(param, index) {

            let isSelected = this.item[param][index].selected || false

            if (!isSelected)
                this.item[param].forEach(item => {
                    if (item.selected)
                        delete item.selected
                })


            this.item[param][index].selected =
                !(this.item[param][index].selected)

            this.$emit("update:item", this.item)
        },
    }
}
</script>
