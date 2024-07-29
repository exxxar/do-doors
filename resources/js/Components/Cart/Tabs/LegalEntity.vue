<!-- <script>
export default {
	setup () {
		

		return {}
	}
}
</script> -->

<template>
	<div class="tab-pane fade show active" id="legal_entity-tab-pane" role="tabpanel"
                aria-labelledby="legal_entity" tabindex="0">
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
                        <li><a class="dropdown-item" @click="selectInfo(null)" href="javascript:void(0)">Не выбрано</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="javascript:void(0)" @click="selectInfo(client)"
                                v-for="client in self_clients">{{ client.title || null }}
                                ({{ preparedLawStatus(client.status) || 'Не указан' }})</a>
                        </li>
                    </ul>
                </div>

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
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="1" v-model="clientForm.work_with_nds"
                                name="flexRadioDefault" id="work-with-nds">
                            <label class="form-check-label" for="work-with-nds">
                                Для ООО
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="0" name="flexRadioDefault"
                                v-model="clientForm.work_with_nds" id="work-without-nds">
                            <label class="form-check-label" for="work-without-nds">
                                Для ИП
                            </label>
                        </div>
                    </div>
                </div>
            </div>
</template>



<style lang="" scoped>

</style>