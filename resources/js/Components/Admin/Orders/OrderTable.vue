<script setup>
import Pagination from "@/Components/Pagination.vue";
import OrderDetailTable from "@/Components/Admin/Orders/OrderDetailTable.vue";
import CalcPreview from "@/Components/Calc/CalcPreview.vue";
</script>


<template>
    <div class="row">
        <div class="col-12">

            <div class="input-group mb-3">
                <div class="form-floating">
                    <input type="search"
                           v-model="search"
                           @keydown.enter="sortAndLoad('id')"
                           class="form-control" id="search-orders">
                    <label

                        for="search-orders">Поиск по заказам</label>
                </div>

                <div class="dropdown">
                    <button class="btn btn-outline-secondary rounded-0 h-100" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                        <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item"
                               href="javascript:void(0)"
                               @click="sortAndLoad('id')">
                            <i class="fa-solid fa-magnifying-glass"></i> Искать</a>
                        </li>
                        <li><a class="dropdown-item"
                               @click="filteredDownload"
                               href="javascript:void(0)">
                            <i class="fa-regular fa-file-excel"></i> Скачать в Excel
                        </a></li>
                    </ul>
                </div>


            </div>


        </div>
        <div class="col-12">
            <VueDatePicker
                class="rounded-0"
                locale="ru"
                range

                multi-calendars
                v-model="sort.date">
                <template #action-row="{ internalModelValue, selectDate,closePicker  }">
                    <div class="action-row">
                        <button class="btn btn-dark rounded-0 mr-2" @click="selectDate">Выбрать</button>
                        <button class="btn btn-outline-secondary rounded-0" @click="closePicker">Закрыть</button>
                    </div>
                </template>

            </VueDatePicker>
        </div>
        <div class="col-12">
            <span
                class="badge  mr-1 rounded-0 cursor-pointer"
                v-bind:class="{'bg-dark':table[item].value===true,'bg-secondary':table[item].value===false}"
                @click="changeColumns(item)"
                v-for="item in Object.keys(table)">{{ table[item].title || '-' }}</span>
            <span
                @click="changeColumns(null)"
                class="badge  mr-1 bg-danger rounded-0 cursor-pointer"><i class="fa-solid fa-retweet"></i></span>
            <span
                @click="resetColumns"
                class="badge  mr-1 bg-secondary rounded-0 cursor-pointer"><i class="fa-solid fa-xmark"></i></span>
        </div>
    </div>

    <template v-if="selected_orders.length>0">
        <p  class="my-3">Выбрано <span>({{selected_orders.length}})</span> элементов:
            <span
                @click="selectOrder(item)"
                class="badge mr-1 bg-dark rounded-0 cursor-pointer" v-for="item in selected_orders">{{item}}</span>
            <span
                @click="selected_orders = []"
                class="badge mr-1 bg-secondary rounded-0 cursor-pointer"><i class="fa-solid fa-xmark"></i></span>
        </p>
        <div class="d-flex flex-wrap">
            <button
                @click="downloadSelectedOrders"
                type="button" class="btn btn-dark rounded-0 mr-2">Скачать эксель</button>

        </div>
    </template>

    <p class="my-2 small italic" v-if="paginate_object">Найдено результатов
        <strong>{{ paginate_object.meta.total }}</strong></p>
    <div class="d-flex scrollable-area">
        <table class="table" v-if="items.length>0">
            <thead>
            <tr>
                <th scope="col" class="cursor-pointer" @click="sortAndLoad('id')">#
                    <span v-if="sort.direction === 'desc'&&sort.column === 'id'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'id'"><i
                        class="fa-solid fa-caret-up"></i></span>
                </th>
                <th scope="col" class="text-center">Действие</th>
                <th
                    v-if="table.contract_number.value"
                    scope="col" class="text-center cursor-pointer" @click="sortAndLoad('contract_number')">Номер
                    договора
                    <span v-if="sort.direction === 'desc'&&sort.column === 'contract_number'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'contract_number'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th
                    v-if="table.contract_date.value"
                    scope="col" class="text-center cursor-pointer" @click="sortAndLoad('contract_date')">Дата договора
                    <span v-if="sort.direction === 'desc'&&sort.column === 'contract_date'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'contract_date'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th
                    v-if="table.completion_at.value"
                    scope="col" class="text-center cursor-pointer" @click="sortAndLoad('completion_at')">Дата закрытия
                    <span v-if="sort.direction === 'desc'&&sort.column === 'completion_at'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'completion_at'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th
                    v-if="table.client_id.value"
                    scope="col" class="text-center cursor-pointer" @click="sortAndLoad('client_id')">Клиент
                    <span v-if="sort.direction === 'desc'&&sort.column === 'client_id'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'client_id'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th
                    v-if="table.status.value"
                    scope="col" class="text-center cursor-pointer" @click="sortAndLoad('status')">Статус заказа
                    <span v-if="sort.direction === 'desc'&&sort.column === 'status'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'status'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>


                <th
                    v-if="table.source.value"
                    scope="col" class="text-center cursor-pointer" @click="sortAndLoad('source')">Источник
                    <span v-if="sort.direction === 'desc'&&sort.column === 'source'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'source'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th
                    v-if="table.contact_person.value"
                    scope="col" class="text-center cursor-pointer" @click="sortAndLoad('contact_person')">Контактное
                    лицо
                    <span v-if="sort.direction === 'desc'&&sort.column === 'contact_person'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'contact_person'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th
                    v-if="table.phone.value"
                    scope="col" class="text-center cursor-pointer" @click="sortAndLoad('phone')">Телефон
                    <span v-if="sort.direction === 'desc'&&sort.column === 'phone'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'phone'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th
                    v-if="table.organizational_form.value"
                    scope="col" class="text-center cursor-pointer" @click="sortAndLoad('organizational_form')">На ип\ооо
                    <span v-if="sort.direction === 'desc'&&sort.column === 'organizational_form'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'organizational_form'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th
                    v-if="table.contract_amount.value"
                    scope="col" class="text-center cursor-pointer" @click="sortAndLoad('contract_amount')">Сумма
                    договора
                    <span v-if="sort.direction === 'desc'&&sort.column === 'contract_amount'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'contract_amount'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th
                    v-if="table.paid.value"
                    scope="col" class="text-center cursor-pointer" @click="sortAndLoad('paid')">Оплачено
                    <span v-if="sort.direction === 'desc'&&sort.column === 'paid'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'paid'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th
                    v-if="table.debt.value"
                    scope="col" class="text-center cursor-pointer" @click="sortAndLoad('debt')">Задолженность
                    <span v-if="sort.direction === 'desc'&&sort.column === 'debt'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'debt'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <th
                    v-if="table.profit.value"
                    scope="col" class="text-center cursor-pointer" @click="sortAndLoad('profit')">Прибыль
                    <span v-if="sort.direction === 'desc'&&sort.column === 'profit'"><i
                        class="fa-solid fa-caret-down"></i></span>
                    <span v-if="sort.direction === 'asc'&&sort.column === 'profit'"><i
                        class="fa-solid fa-caret-up"></i></span>

                </th>

                <!--
                                <th
                                    scope="col" class="text-center cursor-pointer" @click="sortAndLoad('updated_at')">
                                    Дата изменения
                                    <span v-if="sort.direction === 'desc'&&sort.column === 'updated_at'"><i
                                        class="fa-solid fa-caret-down"></i></span>
                                    <span v-if="sort.direction === 'asc'&&sort.column === 'updated_at'"><i
                                        class="fa-solid fa-caret-up"></i></span>
                                </th>-->

            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in items">
                <th scope="row">
                    <div class="form-check">
                        <input
                            :value="item.id"
                            v-model="selected_orders"
                            class="form-check-input" type="checkbox" value="" :id="'order-check-'+index">
                        <label class="form-check-label" :for="'order-check-'+index">
                            {{ item.id || index }}
                        </label>
                    </div>
                </th>
                <td class="text-center">
                    <div class="dropdown">
                        <button class="btn btn-link" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item"
                                   target="_blank"
                                   :href="'/orders/download-order-excel/'+item.id"><i
                                class="fa-regular fa-file-excel mr-2"></i>Скачать
                                Excel-документ по заказу</a></li>


                            <li><a class="dropdown-item"
                                   @click="downloadDocument(item)"
                                   href="javascript:void(0)">
                                <i class="fa-solid fa-file-signature mr-2"></i>Скачать
                                договор</a></li>
                            <li><a class="dropdown-item"
                                   @click="selectItemForEdit(item)"
                                   href="javascript:void(0)"><i class="fa-solid fa-pen mr-2"></i>Редактор заказа</a>
                            </li>

                            <!--
                                                        <li><a class="dropdown-item"
                                                               @click="selectItem(item)"
                                                               href="javascript:void(0)"><i class="fa-solid fa-pen mr-2"></i>Детали заказа</a></li>
                            -->

                            <li><a class="dropdown-item text-danger"
                                   @click="removeItem(item.id)"
                                   href="javascript:void(0)"><i class="fa-solid fa-trash-can mr-2"></i>Удалить</a>
                            </li>
                        </ul>
                    </div>
                </td>
                <td
                    v-if="table.contract_number.value"
                    class="text-center" @click="selectItem(item)">
                    {{ item.contract_number || '-' }}
                </td>
                <td
                    v-if="table.contract_date.value"
                    class="text-center" @click="selectItem(item)">
                    {{ item.contract_date || '-' }}
                </td>
                <td
                    v-if="table.completion_at.value"
                    class="text-center">
                    {{ item.completion_at || '-' }}
                </td>

                <td
                    v-if="table.client_id.value"
                    class="text-center">
                    {{ item.client_id || '-' }}
                </td>

                <td
                    v-if="table.status.value"
                    class="text-center">
                    <span v-if="(item.status||0)<=2">{{ order_status[item.status] }}</span>
                    <span v-else>Не указан</span>
                </td>

                <td
                    v-if="table.source.value"
                    class="text-center">
                    {{ item.source || '-' }}
                </td>

                <td
                    v-if="table.contact_person.value"
                    class="text-center">
                    {{ item.contact_person || '-' }}
                </td>

                <td
                    v-if="table.phone.value"
                    class="text-center">
                    {{ item.phone || '-' }}
                </td>

                <td
                    v-if="table.organizational_form.value"
                    class="text-center">
                    {{ item.organizational_form || '-' }}
                </td>

                <td
                    v-if="table.contract_amount.value"
                    class="text-center">
                    {{ item.contract_amount || 0 }}
                </td>

                <td
                    v-if="table.paid.value"
                    class="text-center">
                    {{ item.paid || 0 }}
                </td>

                <td
                    v-if="table.debt.value"
                    class="text-center">
                    {{ item.debt || 0 }}
                </td>

                <td
                    v-if="table.profit.value"
                    class="text-center">
                    {{ item.profit || 0 }}
                </td>


                <!--                <td class="text-center">
                                    {{ item.updated_at || '-' }}
                                </td>-->

            </tr>

            </tbody>
        </table>
    </div>
    <div class="alert alert-success rounded-0" role="alert" v-if="items.length===0">
        <h4 class="alert-heading">Заказы</h4>
        <p>К сожалению, раздел заказов пуст.</p>
    </div>
    <div class="row mb-3" v-if="items.length>0">
        <div class="col-12">
            <Pagination
                v-on:pagination_page="loadOrders"
                v-if="paginate_object"
                :pagination="paginate_object"/>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="order-details" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Детали заказа</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <OrderDetailTable v-if="selected_order&&!loading" :order-id="selected_order.id"></OrderDetailTable>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-0" data-bs-dismiss="modal">Закрыть
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade  " id="confirm-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">

                <div class="modal-body">
                    <div class="d-flex justify-center p-3">
                        <img src="/images/logo.png" style="width: 100px;" alt="">
                    </div>
                    <h3 class="font-bold text-center py-3">{{ confirm.title || '-' }}</h3>
                    <p class="text-center pb-3">{{ confirm.message || '-' }}</p>

                    <div class="row  mb-3">
                        <div class="col-md-6 d-flex justify-center">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       value="1"
                                       v-model="confirm.work_with_nds"
                                       name="flexRadioDefault"
                                       id="work-with-nds">
                                <label class="form-check-label"
                                       for="work-with-nds">
                                    Работаю с НДС
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6  d-flex justify-center">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       value="0"
                                       name="flexRadioDefault"
                                       v-model="confirm.work_with_nds"
                                       id="work-without-nds">
                                <label class="form-check-label"
                                       for="work-without-nds">
                                    Работаю без НДС
                                </label>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-6">
                            <button class="btn btn-dark rounded-0 w-100" type="button" @click="downloadDocument">Скачать
                                договор
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-secondary rounded-0 w-100" @click="confirm_modal.hide()">
                                Закрыть
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="order-editor-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content rounded-0">

                <div class="modal-body">
                    <template v-if="selected_item">

                        <CalcPreview
                            :can-edit="true"
                            :doors="selected_item.details"
                            :order="selected_item"></CalcPreview>


                    </template>
                </div>

            </div>
        </div>
    </div>

</template>
<script>
import {mapGetters} from "vuex";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'


export default {
    components: {VueDatePicker},
    data() {
        return {
            editor_modal: null,
            selected_orders: [],
            selected_item: null,
            table: {
                contract_number: {
                    title: 'Номер договора',
                    value: true,
                },
                contract_date: {
                    title: 'Дата договора',
                    value: true,
                },
                completion_at: {
                    title: 'Дата закрытия',
                    value: true,
                },
                client_id: {
                    title: 'Идентификатор клиента',
                    value: true,
                },
                status: {
                    title: 'Статус',
                    value: true,
                },
                source: {
                    title: 'Источник',
                    value: true,
                },
                contact_person: {
                    title: 'Контактное лицо',
                    value: true,
                },
                phone: {
                    title: 'Номер телефона',
                    value: true,
                },
                organizational_form: {
                    title: 'Организационная форма',
                    value: true,
                },
                contract_amount: {
                    title: 'Сумма договора',
                    value: true,
                },
                paid: {
                    title: 'Оплачено',
                    value: true,
                },
                debt: {
                    title: 'Остаток',
                    value: true,
                },
                profit: {
                    title: 'Доход',
                    value: true,
                },
            },
            sort: {
                column: null,
                date: null,
                direction: "desc",
            },
            selected_order: null,
            order_detail_modal: null,
            order_status: ["Новый заказ", "В работе", "Завершен"],
            search: null,
            current_page: 0,
            paginate_object: null,
            loading: false,
            confirm_modal: null,
            confirm: {
                title: null,
                message: null,
                work_with_nds: 1,
                item: null,
            },
            items: [
                {
                    id: null,
                    contract_number: null,
                    contract_date: null,
                    completion_at: null,
                    client_id: null,
                    status: null,
                    source: null,
                    contact_person: null,
                    phone: null,
                    organizational_form: null,
                    contract_amount: null,
                    paid: null,
                    debt: null,
                    profit: null,

                }
            ]
        }
    },
    computed: {
        ...mapGetters(['getOrders', 'getOrdersPaginateObject']),
    },
    mounted() {
        this.loadOrders();
        this.order_detail_modal = new bootstrap.Modal(document.getElementById('order-details'), {})
        this.confirm_modal = new bootstrap.Modal(document.getElementById('confirm-modal'), {})
        this.editor_modal = new bootstrap.Modal(document.getElementById('order-editor-modal'), {})
    },
    methods: {
        selectOrder(id) {
            let index = this.selected_orders.findIndex(index => index === id)

            if (index === -1)
                this.selected_orders.push(id)
            else
                this.selected_orders.splice(index, 1)
        },
        resetColumns() {
            Object.keys(this.table).forEach(key => {
                this.table[key].value = true
            })
        },
        changeColumns(item) {
            if (item)
                this.table[item].value = !this.table[item].value
            else {
                Object.keys(this.table).forEach(key => {
                    this.table[key].value = !this.table[key].value
                })
            }
        },
        openConfirmModal(title, message, item) {
            this.confirm.title = title || null
            this.confirm.message = message || null
            this.confirm.item = item || null

            this.confirm_modal.show()
        },
        sortAndLoad(column) {
            this.sort.column = column
            this.sort.direction = this.sort.direction === "desc" ? "asc" : "desc"
            this.loadOrders(this.current_page)
        },
        downloadSelectedOrders(){
            let order = this.sort
            let from = (order.date || []).length > 0 ? (new Date(order.date[0])).getTime() : null;
            let to = (order.date || []).length > 1 ? (new Date(order.date[1])).getTime() : null;

            let tmp = `/orders/download-filtered-orders?order=id&ids=${this.selected_orders.join(',')}&type=multiply`



            if (from && to)
                tmp += `&df=${from}&dt=${to}`

            if (this.search)
                tmp += `&search=${this.search || null}`

            window.open(tmp, '_blank').focus();
        },
        filteredDownload() {
            let order = this.sort
            let from = (order.date || []).length > 0 ? (new Date(order.date[0])).getTime() : null;
            let to = (order.date || []).length > 1 ? (new Date(order.date[1])).getTime() : null;

            let tmp = `/orders/download-filtered-orders?order=id`


            if (from && to)
                tmp += `&df=${from}&dt=${to}`

            if (this.search)
                tmp += `&search=${this.search || null}`

            window.open(tmp, '_blank').focus();
        },
        downloadDocument(order) {

            window.open(`/orders/download-contract?c=${order.client_id}&o=${order.id}`, '_blank').focus();
            this.confirm_modal.hide()
        },
        loadOrders(page = 0) {
            this.current_page = page

            let order = this.sort

            let from = (order.date || []).length > 0 ? order.date[0] : null;
            let to = (order.date || []).length > 1 ? order.date[1] : null;


            this.$store.dispatch("loadOrders", {
                dataObject: {
                    search: this.search,
                    order: this.sort.column,
                    direction: this.sort.direction,
                    df: from || null,
                    dt: to || null
                },
                page: this.current_page
            }).then(resp => {
                this.items = this.getOrders
                this.paginate_object = this.getOrdersPaginateObject

            }).catch(() => {
                this.loading = false
            })
        },
        selectItemForEdit(item) {
            //this.$emit("select", item)
            if (item == null) {
                this.selected_item = null
                this.editor_modal.hide()
                return;
            }

            this.selected_item = null
            this.$nextTick(() => {
                this.selected_item = item
                this.editor_modal.show()
            })
        },
        selectItem(item) {
            // this.$emit("select", item)
            this.loading = true
            this.selected_order = item
            this.$nextTick(() => {
                this.loading = false
                this.order_detail_modal.show();
            })

        },
        duplicateItem(id) {
            this.$store.dispatch("duplicateOrder", {
                materialId: id
            }).then(() => {
                this.sortAndLoad("id")
            })
        },
        removeItem(id) {
            this.$store.dispatch("removeOrder", {
                materialId: id
            }).then(() => {
                this.sortAndLoad("id")
            })
        },

    }
}
</script>
<style>
.scrollable-area {
    width: 100%;
    overflow-y: auto;
}

:root {

    --dp-border-radius: 0px; /*Configurable border-radius*/
    --dp-cell-border-radius: 0px; /*Specific border radius for the calendar cell*/
    --dp-border-color: red;
}

.dp__theme_light {
    --dp-border-color: black;
    --dp-primary-color: #000000;
}

.action-row {
    display: flex;
    justify-content: center;
    width: 100%;
}
</style>
