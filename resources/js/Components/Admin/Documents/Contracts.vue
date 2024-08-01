<template>
    <div class="row">
        <div class="col-12">
            <h6 class="font-bold">Справочная информация</h6>

            <div class="alert alert-light my-3" role="alert">
                Ниже представлены ключи, которые подставляются в шаблоны договоров клиента.
            </div>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col" style="width: 30px;">#</th>
                    <th scope="col" style="width: 100px;">Ключ</th>
                    <th scope="col">Описание</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row" style="width: 30px;">1</th>
                    <td style="width: 100px;"><strong>${numb_doc}</strong></td>
                    <td>Номер договора</td>
                </tr>
                <tr>
                    <th scope="row" style="width: 30px;">2</th>
                    <td style="width: 100px;"><strong>${date_doc}</strong></td>
                    <td>Дата договора</td>
                </tr>
                <tr>
                    <th scope="row" style="width: 30px;">3</th>
                    <td style="width: 100px;"><strong>${phone}</strong></td>
                    <td>Номер телефона клиента</td>
                </tr>

                <tr>
                    <th scope="row" style="width: 30px;">4</th>
                    <td style="width: 100px;"><strong>${title}</strong></td>
                    <td>Названии организации для юр лиц или ФИО для физ лиц</td>
                </tr>
                <tr>
                    <th scope="row" style="width: 30px;">5</th>
                    <td style="width: 100px;"><strong>${member}</strong></td>
                    <td>ФИО представителя организации (для юр лиц)</td>
                </tr>
                <tr>
                    <th scope="row" style="width: 30px;">6</th>
                    <td style="width: 100px;"><strong>${fio}</strong></td>
                    <td>Фамилия и инициалы клиента</td>
                </tr>
                <tr>
                    <th scope="row" style="width: 30px;">7</th>
                    <td style="width: 100px;"><strong>${passport}</strong></td>
                    <td>Серия номер паспорта (для физ лиц)</td>
                </tr>
                <tr>
                    <th scope="row" style="width: 30px;">8</th>
                    <td style="width: 100px;"><strong>${passport_issued}</strong></td>
                    <td>Кем выдан паспорт (для физ лиц)</td>
                </tr>

                <tr>
                    <th scope="row" style="width: 30px;">9</th>
                    <td style="width: 100px;"><strong>${email}</strong></td>
                    <td>Почтовый адрес</td>
                </tr>

                <tr>
                    <th scope="row" style="width: 30px;">10</th>
                    <td style="width: 100px;"><strong>${fact_address}</strong></td>
                    <td>Фактический адрес</td>
                </tr>

                <tr>
                    <th scope="row" style="width: 30px;">11</th>
                    <td style="width: 100px;"><strong>${law_address}</strong></td>
                    <td>Юридический адрес</td>
                </tr>
                <tr>
                    <th scope="row" style="width: 30px;">12</th>
                    <td style="width: 100px;"><strong>${bank_name}</strong></td>
                    <td>Название банка</td>
                </tr>
                <tr>
                    <th scope="row" style="width: 30px;">13</th>
                    <td style="width: 100px;"><strong>${bik}</strong></td>
                    <td>БИК</td>
                </tr>
                <tr>
                    <th scope="row" style="width: 30px;">14</th>
                    <td style="width: 100px;"><strong>${ksch}</strong></td>
                    <td>к/сч</td>
                </tr>
                <tr>
                    <th scope="row" style="width: 30px;">15</th>
                    <td style="width: 100px;"><strong>${rsch}</strong></td>
                    <td>р/сч</td>
                </tr>
                

                <tr>
                    <th scope="row" style="width: 30px;">16</th>
                    <td style="width: 100px;"><strong>${inn}</strong></td>
                    <td>ИНН</td>
                </tr>

                <tr>
                    <th scope="row" style="width: 30px;">17</th>
                    <td style="width: 100px;"><strong>${kpp}</strong></td>
                    <td>КПП</td>
                </tr>

                <tr>
                    <th scope="row" style="width: 30px;">18</th>
                    <td style="width: 100px;"><strong>${ogrn}</strong></td>
                    <td>ОГРН</td>
                </tr>

                <tr>
                    <th scope="row" style="width: 30px;">19</th>
                    <td style="width: 100px;"><strong>${okpo}</strong></td>
                    <td>ОКПО</td>
                </tr>

                <!-- <tr>
                    <th scope="row" style="width: 30px;">10</th>
                    <td style="width: 100px;"><strong>${requisites}</strong></td>
                    <td>Банковские реквизиты, выбранные как "по умолчанию"</td>
                </tr> -->
                <tr>
                    <th scope="row" style="width: 30px;">20</th>
                    <td style="width: 100px;"><strong>${work_days}</strong></td>
                    <td>Срок передачи товара Покупателю</td>
                </tr>

                <tr>
                    <th scope="row" style="width: 30px;">21</th>
                    <td style="width: 100px;"><strong>${total_price}</strong></td>
                    <td>Стоимость всех товаров, руб</td>
                </tr>
                <tr>
                    <th scope="row" style="width: 30px;">22</th>
                    <td style="width: 100px;"><strong>${current_payed}</strong></td>
                    <td>Начальная внесенная покупателем сумма, руб</td>
                </tr>


                <tr>
                    <th scope="row" style="width: 30px;">23</th>
                    <td style="width: 100px;"><strong>${payed_percent}</strong></td>
                    <td>Процент внесенной суммы от полной стоимости</td>
                </tr>
                <tr>
                    <th scope="row" style="width: 30px;">24</th>
                    <td style="width: 100px;"><strong>${last_payment}</strong></td>
                    <td>Оставшиеся денежные средства</td>
                </tr>

                <!-- <tr>
                    <th scope="row" style="width: 30px;">13</th>
                    <td style="width: 100px;"><strong>${delivery_terms}</strong></td>
                    <td>Срок передачи товара покупателю</td>
                </tr> -->

                </tbody>
            </table>


        </div>
    </div>

    <form v-on:submit.prevent="submit(1)" class="row mb-3">
        <div class="col-12">
            <a class="mb-0 small text-red-600" href="/orders/download-template?type=1" target="_blank">Скачать текущий
                шаблон для ООО</a>
        </div>
        <div class="col-md-10">
            <div class="form-floating border-gray-100 border">
                <input type="file" class="form-control"
                       accept="doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                       id="door-contract-1"
                       ref="doorFileContract1"
                       @change="onChangeFile"
                       placeholder="name@example.com" required>
                <label for="door-contract-1">Договор для ООО</label>
            </div>
        </div>
        <div class="col-md-2">
            <button class="btn btn-dark rounded-0 w-100 h-100">Загрузить</button>
        </div>
    </form>
    <form v-on:submit.prevent="submit(0)" class="row mb-3">
        <div class="col-12">
            <a class="mb-0 small text-red-600" href="/orders/download-template?type=0" target="_blank">Скачать текущий
                шаблон ИП</a>
        </div>
        <div class="col-md-10">
            <div class="form-floating border-gray-100 border">
                <input type="file" class="form-control"
                       accept="doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                       id="door-contract-2"
                       ref="doorFileContract2"
                       @change="onChangeFile"
                       placeholder="name@example.com" required>
                <label for="door-contract-2">Договор для ИП</label>
            </div>
        </div>
        <div class="col-md-2">
            <button class="btn btn-dark rounded-0 w-100 h-100">Загрузить</button>
        </div>
    </form>

</template>
<script>
export default {
    data() {
        return {
            file: null
        }
    },
    methods: {
        onChangeFile(e) {
            const files = e.target.files
            this.file = files[0]

        },
        submit(type) {
            let data = new FormData();

            data.append('file', this.file);
            data.append('type', type);


            this.$store.dispatch("updateContractTemplate", {
                contractTemplateForm: data
            }).then((response) => {
                if (type === 1)
                    this.$refs.doorFileContract1.value = null

                if (type === 0)
                    this.$refs.doorFileContract2.value = null

                this.$notify({
                    title: "DoDoors",
                    text: "Договор успешно загружен",
                    type:"success"
                });

                this.$emit("callback")
            }).catch(error => {
                this.$notify({
                    title: "DoDoors",
                    text: "Ошибка загрузки договора",
                    type:"error"
                });
            })
        }
    }
}
</script>
