<template>

    <template v-if="clientForm">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" v-mask="'+7(###)###-##-##'" v-model="clientForm.phone"
                   id="checkout-phone" placeholder="name@example.com" required>
            <label for="checkout-phone">Ваш номер телефона</label>
        </div>

        <div class="form-floating mb-3">
            <input type="email" class="form-control" v-model="clientForm.email" id="checkout-email"
                   placeholder="name@example.com" required>
            <label for="checkout-email">Ваш email</label>
        </div>

        <div class="form-floating">
            <textarea class="form-control border-secondary rounded-0" v-model="clientForm.info"
                      placeholder="Оставьте свой комментарий" id="checkout-info"></textarea>
            <label for="checkout-info">Дополнительная информация</label>
        </div>
        <div class="row  my-3">
            <div class="col-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="1" v-model="clientForm.work_with_nds"
                           name="flexRadioDefault" id="work-with-nds">
                    <label class="form-check-label" for="work-with-nds">
                        С НДС
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="0" name="flexRadioDefault"
                           v-model="clientForm.work_with_nds" id="work-without-nds">
                    <label class="form-check-label" for="work-without-nds">
                        Без НДС
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="2" name="flexRadioDefault"
                           v-model="clientForm.work_with_nds" id="work-without-nds">
                    <label class="form-check-label" for="work-without-nds">
                        Физ-лицо
                    </label>
                </div>
            </div>
        </div>
    </template>

</template>
<script>
export default {
    props:['modelValue'],
    data(){
        return {
            clientForm:null,
        }
    },
    watch: {
        'clientForm': {
            handler(val) {
                this.$emit("update:modelValue", this.clientForm)

            },
            deep: true
        },

    },
    mounted() {
        this.clientForm = this.modelValue
    },
}
</script>
