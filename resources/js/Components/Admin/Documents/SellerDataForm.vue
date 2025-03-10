<template>
    <div class="row" v-if="formData">
        <div class="col-md-6">
            <h5 class="mb-2">Продавец</h5>
            <div class="input-group mb-2 rounded-0 border-dark">
                <div class="form-floating flex-grow-1">
                    <input type="text" class="form-control" id="company" v-model="formData.title"/>
                    <label for="company">Компания или Название ИП</label>
                </div>
                <span class="input-group-text rounded-0 border-dark">{seller_company}</span>
            </div>
            <div class="input-group mb-2 rounded-0 border-dark">
                <div class="form-floating flex-grow-1">
                    <input type="text" class="form-control" id="INN_KPP" v-model="formData.INN_KPP"/>
                    <label for="INN_KPP">ИНН/КПП</label>
                </div>
                <span class="input-group-text rounded-0 border-dark">{seller_INN_KPP}</span>
            </div>
            <div class="input-group mb-2 rounded-0 border-dark">
                <div class="form-floating flex-grow-1">
                    <input type="text" class="form-control" id="OGRN" v-model="formData.OGRN"/>
                    <label for="OGRN">ОГРН или ОГРНИП</label>
                </div>
                <span class="input-group-text rounded-0 border-dark">{seller_OGRN}</span>
            </div>
            <template v-if="formData.supplier_representative">
                <h5 class="mb-2">Поставщик</h5>
                <div class="input-group mb-2 rounded-0 border-dark">
                    <div class="form-floating flex-grow-1">
                        <input type="text" class="form-control" id="full_name"
                               v-model="formData.supplier_representative.full_name"/>
                        <label for="full_name">ФИО</label>
                    </div>
                    <span class="input-group-text rounded-0 border-dark">{seller_full_name}</span>
                </div>
            </template>

        </div>
        <div class="col-md-6">
            <h5 class="mb-2">Юридический адрес</h5>
            <div class="input-group mb-2 rounded-0 border-dark">
                <div class="form-floating flex-grow-1">
                    <input type="text" class="form-control" id="postal_code"
                           v-model="formData.legal_address.postal_code"/>
                    <label for="postal_code">Почтовый индекс</label>
                </div>
                <span class="input-group-text rounded-0 border-dark">{seller_postal_code}</span>
            </div>
            <div class="input-group mb-2 rounded-0 border-dark">
                <div class="form-floating flex-grow-1">
                    <input type="text" class="form-control" id="region"
                           v-model="formData.legal_address.region"/>
                    <label for="region">Регион</label>
                </div>
                <span class="input-group-text rounded-0 border-dark">{seller_region}</span>
            </div>
            <div class="input-group mb-2 rounded-0 border-dark">
                <div class="form-floating flex-grow-1">
                    <input type="text" class="form-control" id="city" v-model="formData.legal_address.city"/>
                    <label for="city">Город</label>
                </div>
                <span class="input-group-text rounded-0 border-dark">{seller_city}</span>
            </div>
            <div class="input-group mb-2 rounded-0 border-dark">
                <div class="form-floating flex-grow-1">
                    <input type="text" class="form-control" id="street"
                           v-model="formData.legal_address.street"/>
                    <label for="street">Улица</label>
                </div>
                <span class="input-group-text rounded-0 border-dark">{seller_street}</span>
            </div>
            <div class="input-group mb-2 rounded-0 border-dark">
                <div class="form-floating flex-grow-1">
                    <input type="text" class="form-control" id="building"
                           v-model="formData.legal_address.building"/>
                    <label for="building">Дом</label>
                </div>
                <span class="input-group-text rounded-0 border-dark">{seller_building}</span>
            </div>
        </div>
        <div class="col-12">
            <h5 class="mb-2">Банк</h5>
            <div class="input-group mb-2 rounded-0 border-dark">
                <div class="form-floating flex-grow-1">
                    <input type="text" class="form-control" id="name" v-model="formData.bank.name"/>
                    <label for="name">Название банка</label>
                </div>
                <span class="input-group-text rounded-0 border-dark">{seller_name}</span>
            </div>
            <div class="input-group mb-2 rounded-0 border-dark">
                <div class="form-floating flex-grow-1">
                    <input type="text" class="form-control" id="BIC" v-model="formData.bank.BIC"/>
                    <label for="BIC">БИК</label>
                </div>
                <span class="input-group-text rounded-0 border-dark">{seller_BIC}</span>
            </div>
            <div class="input-group mb-2 rounded-0 border-dark">
                <div class="form-floating flex-grow-1">
                    <input type="text" class="form-control" id="correspondent_account"
                           v-model="formData.bank.correspondent_account"/>
                    <label for="correspondent_account">Корреспондентский счет</label>
                </div>
                <span class="input-group-text rounded-0 border-dark">{seller_correspondent_account}</span>
            </div>
            <div class="input-group mb-2 rounded-0 border-dark">
                <div class="form-floating flex-grow-1">
                    <input type="text" class="form-control" id="checking_account"
                           v-model="formData.bank.checking_account"/>
                    <label for="checking_account">Расчетный счет</label>
                </div>
                <span class="input-group-text rounded-0 border-dark">{seller_checking_account}</span>
            </div>
            <div class="input-group mb-2 rounded-0 border-dark">
                <div class="form-floating flex-grow-1">
                    <input type="text" class="form-control" id="phone" v-model="formData.phone"/>
                    <label for="phone">Номер телефона</label>
                </div>
                <span class="input-group-text rounded-0 border-dark">{seller_phone}</span>
            </div>
            <div class="input-group mb-2 rounded-0 border-dark">
                <div class="form-floating flex-grow-1">
                    <input type="email" class="form-control" id="email" v-model="formData.email"/>
                    <label for="email">Email</label>
                </div>
                <span class="input-group-text rounded-0 border-dark">{seller_email}</span>
            </div>
        </div>

    </div>
</template>
<script>
export default {
   props:["modelValue"],
    data(){
      return {
          formData:null
      }
    },
    mounted() {
      this.formData = this.modelValue
    },
    watch: {
        'formData': {
            handler(val) {
                this.$emit('update:modelValue', this.formData)
            },
            deep: true
        }
    },
}
</script>
