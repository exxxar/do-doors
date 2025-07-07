import util from './utilites';


const BASE_ORDERS_LINK = '/orders'

let state = {
    orders: [],
    orders_paginate_object: null,
}

const getters = {
    getOrders: state => state.orders || [],
    getOrderById: (state) => (id) => {
        return state.orders.find(item => item.id === id)
    },
    getOrdersPaginateObject: state => state.orders_paginate_object || null,
}

const actions = {



    async sendOrderToBitrix(context, payload ) {
        let link = `${BASE_ORDERS_LINK}/send-to-bitrix`

        let _axios = util.makeAxiosFactory(link, "POST", payload)

        return _axios.then((response) => {

            return Promise.resolve(response);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async sendOrderToTelegram(context, payload ) {
        let link = `${BASE_ORDERS_LINK}/send-to-telegram`

        let _axios = util.makeAxiosFactory(link, "POST", payload)

        return _axios.then((response) => {

            return Promise.resolve(response);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async sendMsgBackCall(context, payload = { form: null }) {
        let link = `/sendReqCallToBot`

        let _axios = util.makeAxiosFactory(link, "POST", payload.form)

        return _axios.then((response) => {

            return Promise.resolve(response);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },

    async loadOrder(context, payload = { order_id: null }) {

        let link = `${BASE_ORDERS_LINK}/order-info`
        let method = 'POST'

        let _axios = util.makeAxiosFactory(link, method, payload)

        return _axios.then((response) => {
            return Promise.resolve(response);
        }).catch(err => {
            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },

    async loadOrders(context, payload = { dataObject: null, page: 0, size: 50 }) {
        let page = payload.page || 0
        let size = payload.size || 50

        let link = `${BASE_ORDERS_LINK}?page=${page}&size=${size}`
        let method = 'POST'
        let data = payload.dataObject

        let _axios = util.makeAxiosFactory(link, method, data)

        return _axios.then((response) => {
            let dataObject = response.data
            context.commit("setOrders", dataObject.data)
            delete dataObject.data
            context.commit('setOrdersPaginateObject', dataObject)
            return Promise.resolve();
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },


    async updateContractTemplate(context, payload = { contractTemplateForm: null }) {
        let link = `${BASE_ORDERS_LINK}/update-contract-templates`
        let _axios = util.makeAxiosFactory(link, "POST", payload.contractTemplateForm)
        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async editDoorInOrder(context, payload = { doorForm: null }) {
        let link = `${BASE_ORDERS_LINK}/edit-door-in-order`

        let _axios = util.makeAxiosFactory(link, "POST", payload.doorForm)

        return _axios.then((response) => {

            return Promise.resolve(response.data);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async editOrder(context, payload = {clientForm: null}) {
        let link = `${BASE_ORDERS_LINK}/edit-order`

        let _axios = util.makeAxiosFactory(link, "POST", payload.clientForm)

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async storeOrder(context, payload = { orderForm: null }) {
        let link = `${BASE_ORDERS_LINK}/store`

        let _axios = util.makeAxiosFactory(link, "POST", payload.orderForm)

        return _axios.then((response) => {

            return Promise.resolve(response.data);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async removeOrder(context, payload = { orderId: null }) {
        let link = `${BASE_ORDERS_LINK}/${payload.orderId}`

        let _axios = util.makeAxiosFactory(link, 'DELETE')

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async duplicateOrder(context, payload = { orderId: null }) {
        let link = `${BASE_ORDERS_LINK}/duplicate/${payload.orderId}`

        let _axios = util.makeAxiosFactory(link, 'GET')

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
}
const mutations = {
    setOrders(state, payload) {
        state.orders = payload || [];
        localStorage.setItem('dodoors_orders', JSON.stringify(payload));
    },
    setOrdersPaginateObject(state, payload) {
        state.orders_paginate_object = payload || [];
        localStorage.setItem('dodoors_orders_paginate_object', JSON.stringify(payload));
    }
}

const ordersModule = {
    state,
    mutations,
    actions,
    getters
}
export default ordersModule;
