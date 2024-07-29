<template>
	
   

                <!-- инпут с кнопкой выпадалкой сделать нужно отсеивание тока физ лиц в выпадалку -->
                <div class="input-group mb-3">
                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" v-model="clientForm.name" id="checkout-name"
                                placeholder="name@example.com" required>
                            <label for="checkout-name">Ваше Ф.И.О.</label>
                        </div>
                        <button v-if="self_clients.length>0" class="btn btn-outline-secondary" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end rounded-0">
                            <li><a class="dropdown-item" @click="selectInfo(null)" href="javascript:void(0)">Не
                                    выбрано</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" @click="selectInfo(client)">
                                    <template v-for="client in self_clients">
                                        <div v-if="client.status == 'individual' ">
                                            {{ client.title || null }}
                                            ({{ preparedLawStatus(client.status) || 'Не указан' }})
                                        </div>

                                    </template>

                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
                <!-- инпут с кнопкой выпадалкой сделать нужно отсеивание тока физ лиц в выпадалку -->
                
                
                
                
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
            
</template>



<script>
 import { mapGetters } from "vuex";
    import { mask } from 'vue-the-mask'
 export default {
directives: { mask },
    data() {
            return {
                self_clients: [],
                clientForm:{
                    id: null,
                    name: null,
                    phone: null,
                    email: null,
                    info: null,
                    promo: null,
                    work_with_nds: 1,
                    items: [],
                    current_payed: 0,
                    payed_percent: 0,
                    delivery_terms: null,
                }

            }
        },
        methods:{
              loadSelfClients() {

                this.$store.dispatch("loadSelfClients").then(resp => {
                    this.self_clients = resp.data || []

                }).catch(() => {

                })
            },
        }

 }


</script>