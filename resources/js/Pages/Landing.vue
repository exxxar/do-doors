<script setup>
import {
    Head,
    Link,
    useForm
} from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

import ApplicationLogo from '@/Components/ApplicationLogo.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    }
});
</script>

<script>
import {mask} from 'vue-the-mask'


export default{

    directives:{mask},
    data(){
        return{
            form:{
                phone:'',
                fio:'',
                msg: ''
            },
        }
    },
    methods:{
        submit(){
            this.$store.dispatch("sendMsgBackCall", {
                form: this.form
            }).then((response) => {
                this.$notify({
                    title: "DoDoors",
                    text: response.data,
                    type:"success"
                });

                this.$emit("callback")
            }).catch(error => {

                let msg = `Произошла ошибка: ${error.message}`
                if(error.response.status == 422){
                    msg = "Некорректные данные!"
                }
                this.$notify({
                    title: "DoDoors",
                    text:  msg,
                    type:"error"
                });
            })

        }
    }
}

</script>

<template>
<Head title="Lendos" />
<div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
    <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-end">
        <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Главный экран</Link>
        <template v-else>
            <Link :href="route('login')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Вход</Link>

            <Link v-if="canRegister" :href="route('register')" class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Регистрация</Link>
        </template>
    </div>
<notifications position="top right"/>

    <div class="d-flex flex-col">
        <div class="w-100 d-flex justify-center align-items-center my-5">
            <ApplicationLogo class="w-20 h-20 fill-current text-gray-500"></ApplicationLogo>
        </div>

        <div class="bg-white drop-shadow-xl ">

            <form @submit.prevent="submit">
                <div class="my-4 mx-4">

                    <h2 class=" fw-bold uppercase my-3 text-center mb-2">Оставьте заявку на обратный звонок</h2> <!-- text-indigo-900-->

                    <div class="form-floating mb-3">
                        <input type="text"
                               v-mask="'+7(###)###-##-##'" v-model="form.phone" required
                               class="form-control" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">Номер телефона</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text"
                               v-model="form.fio" required
                               class="form-control" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">Ф.И.О.</label>
                    </div>

                    <div class="form-floating">
                    <textarea class="form-control rounded-0 border-dark"
                              v-model="form.msg" required
                              maxlength="4000"
                              style="min-height: 200px;"
                              placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                        <label for="floatingTextarea">Сообщение
                            <span v-if="(form.msg||'').length>0">{{form.msg.length}}/4000</span>
                        </label>
                    </div>


                    <div class="mt-4 flex items-center justify-center">

                        <button
                            :disabled="form.processing"
                            class="btn btn-dark rounded-0">Отправить</button>

                    </div>
                </div>
            </form>
        </div>
    </div>

    </div>
</template>


