<template>
    <div class="form-floating mb-3">
        <input type="text"
               v-model="search"
               class="form-control" id="color-filter" placeholder="Код, цвет, название">
        <label for="color-filter">Фильтрация цвета</label>
    </div>

    <div class="d-flex flex-wrap">
        <span class="badge  mr-1 mb-1 cursor-pointer rounded-0"
              v-bind:class="{'bg-primary':color_blocks.indexOf(item*1000)!=-1,'bg-secondary':color_blocks.indexOf(item*1000)==-1}"
              @click="addFilter(item*1000)"
              v-for="item in 9">RAL {{ item }}000</span>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Код</th>
            <th scope="col">Визуализация</th>
            <th scope="col">Название</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="item in filteredColor">
            <th scope="row">{{ item.code }}</th>
            <td style="width: 200px;">
                <span
                    @click="selectColor(item)"
                    class="d-block w-100 text-white text-center cursor-pointer"
                    v-bind:style="{'background':item.color.hex}">{{ item.color.hex }}</span>
            </td>
            <td>{{ item.names.en }}</td>
        </tr>

        </tbody>
    </table>
</template>
<script>
export default {
    data() {
        return {
            search: null,
            color_blocks: [],
            colors: [],
        }
    },
    computed: {
        filteredColor() {
            let search = this.search || ''

            if (search.length === 0 && this.color_blocks.length == 0)
                return this.colors

            let colors = [];


            Object.keys(this.colors).forEach(key => {
                if (this.colors[key].names.en
                        .trim()
                        .toLowerCase()
                        .indexOf(search
                            .trim()
                            .toLowerCase()) !== -1 ||
                    this.colors[key].code
                        .indexOf(search) !== -1 ||
                    this.colors[key].color.hex
                        .trim()
                        .toLowerCase()
                        .indexOf(search
                            .trim()
                            .toLowerCase()) !== -1)
                    colors.push(this.colors[key])
            })


            if (this.color_blocks.length > 0)
                colors = colors.filter(item => {
                    let tmp = this.color_blocks.filter(sub => {
                        if (item.code >= sub && item.code < (sub + 1000)) {
                            return true
                        }

                    })
                    return tmp.length > 0
                })

            return colors
        }
    },
    mounted() {
        this.loadColorsJSON()
    },
    methods: {
        addFilter(item) {
            let index = this.color_blocks.findIndex(block => block == item)

            if (index != -1)
                this.color_blocks.splice(index, 1)
            else
                this.color_blocks.push(item)

        },
        loadColorsJSON() {
            axios.get("/ral_pretty.json").then(resp => {
                this.colors = resp.data
            })
        },
        selectColor(color) {
            this.$emit("select", color)
        }
    }
}
</script>
