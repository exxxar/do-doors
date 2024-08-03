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
        <div class="form-floating mb-3">
            <input type="text" class="form-control" v-mask="'## ##  ######'" v-model="clientForm.passport"
                   id="checkout-email" placeholder="name@example.com">
            <label for="checkout-email">Паспорт</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" v-model="clientForm.passport_issued" id="checkout-email"
                   placeholder="name@example.com">
            <label for="checkout-email">Выдан</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" v-model="clientForm.delivery_address" id="checkout-email"
                   placeholder="name@example.com" required>
            <label for="checkout-email">Адрес доставки</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" v-model="clientForm.info" id="checkout-email"
                   placeholder="name@example.com">
            <label for="checkout-email">Дополнительная информация</label>
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
