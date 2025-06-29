<template>
    <button type="button" class="btn btn-dark rounded-0" data-bs-toggle="modal"
            :data-bs-target="'#download-contract-by-number'+contractId">
       <slot name="name"></slot>
    </button>

    <!-- Modal -->
    <div class="modal fade" :id="'download-contract-by-number'+contractId" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <form method="get"
                  target="_blank"
                  v-on:submit.prevent="downloadContract" class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Скачивание договора</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-2 rounded-0">
                        <input type="text"
                               :disabled="contractId!=null"
                               v-model="contractForm.contract_id"
                               class="form-control" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">Номер договора</label>
                    </div>
                    <div class="btn-group w-100" role="group" aria-label="Basic example">
                        <button type="button"
                                @click="contractForm.type=-1"
                                v-bind:class="{'btn-dark':contractForm.type===-1,'btn-outline-dark':contractForm.type!==-1}"
                                class="btn rounded-0">По умолчанию</button>
                        <button type="button"
                                @click="contractForm.type=1"
                                v-bind:class="{'btn-dark':contractForm.type===1,'btn-outline-dark':contractForm.type!==1}"
                                class="btn rounded-0">ООО</button>
                        <button type="button"
                                @click="contractForm.type=0"
                                v-bind:class="{'btn-dark':contractForm.type===0,'btn-outline-dark':contractForm.type!==0}"
                                class="btn rounded-0">ИП</button>
                        <button type="button"
                                @click="contractForm.type=2"
                                v-bind:class="{'btn-dark':contractForm.type===2,'btn-outline-dark':contractForm.type!==2}"
                                class="btn rounded-0">ФЛ</button>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary rounded-0 text-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit"
                            :disabled="contractForm.contract_id==null"
                            class="btn btn-dark rounded-0">Скачать</button>
                </div>
            </form>
        </div>
    </div>

</template>

<script>
export default {
    props:['contractId'],
    data() {
        return {

            contractForm:{
                type:-1,
                contract_id:null
            }
        }
    },
    mounted() {
        if (this.contractId)
            this.contractForm.contract_id = this.contractId
    },
    methods: {

        downloadContract(){
            window.open('/orders/download-by-contract?type='+this.contractForm.type+'&id='+this.contractForm.contract_id,'_blank')
        },

    }
}
</script>
