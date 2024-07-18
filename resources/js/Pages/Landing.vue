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
            }
        }
    },
    methods:{
        submit: ()=>{
            console.log("ksdjajdkl")
            console.log(this.form)
            axios.post('/sendReqCallToBot', {form:this.form.value}).then(res=>{
                console.log("dasjlkdkj")
            }).cathch(er=>{
            console.log("errrrr")
            })
        }
    },
}
// import {mask} from 'vue-the-mask'
// // import axios from 'axios';

// export default {
//     directives: {
//         mask
//     },
//     data() {
//         return {
//             form: useForm({
//                 phone: '',
//                 fio: '',
//                 msg: ''
//             })
//         }
//     },
//     methods: {
//         submit:()=>{
//             // axios.post('/sendReqCallToBot', {form:this.form}).then( res=>{
//             //     console.log(res)
//             // } 
//             // )
//         }
//     },
//     mounted:{

//     }
        
// }




</script>


<template>
<Head title="Lendos" />
<div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
    <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-end">
        <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</Link>

        <template v-else>
            <Link :href="route('login')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</Link>

            <Link v-if="canRegister" :href="route('register')" class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</Link>
        </template>
    </div>

    <div class="bg-white drop-shadow-xl ">

        <form @submit.prevent="submit">
            <div class="my-4 mx-4">

                <h1 class=" font-bold text-2xl uppercase my-3 text-center mb-2 text-gray-800">Оставьте заявку на обратный звонок</h1> <!-- text-indigo-900-->

                <InputLabel class="mt-3" for="text" value="Номер телефона" />
                <TextInput id="phone" type="text" class="mt-1 block w-full form-control" v-mask="'+7(###)###-##-##'" v-model="form.phone" required autofocus />

                <InputLabel class="mt-2" for="text" value="ФИО" />
                <TextInput id="fio" type="text" class="mt-1 block w-full" v-model="form.fio" required autofocus />

                <InputLabel class="mt-2" for="text" value="Сообщение" />
                <TextArea id="msg" type="textarea" class="mt-1 block w-full" v-model="form.msg" required autofocus />
                <InputLabel v-if="form.recentlySuccessful" class="mt-3 text-green-500 uppercase" for="text"  value ="Запрос отправлен!" />
                     <InputLabel v-if="form.onError" class="mt-3 text-green-500 uppercase" for="text"  value ="Произошла ошибка отправки на сервер" />
                    <div class="mt-4 flex items-center justify-center">
                        <PrimaryButton  :class="{ 'opacity-25': form.processing }" :disabled="form.processing"> Отправить</PrimaryButton>
                    </div>

                </div>
            </form>
        </div>
    </div> 
</template>


