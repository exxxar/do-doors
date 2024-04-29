import util from './utilites';


const BASE_ORDER_DETAILS_LINK = '/order-details'

let state = {
    orderDetails: [],
    orderDetails_paginate_object: null,
}

const getters = {
    getOrderDetails: state => state.orderDetails || [],
    getOrderDetailById: (state) => (id) => {
        return state.orderDetails.find(item => item.id === id)
    },
    getOrderDetailsPaginateObject: state => state.orderDetails_paginate_object || null,
}

const actions = {
    async loadOrderDetails(context, payload = {dataObject: {order_id:null}, page: 0, size: 50}) {
        let page = payload.page || 0
        let size = payload.size || 50

        let link = `${BASE_ORDER_DETAILS_LINK}?page=${page}&size=${size}`
        let method = 'POST'
        let data = payload.dataObject

        let _axios = util.makeAxiosFactory(link, method, data)

        return _axios.then((response) => {
            let dataObject = response.data
            context.commit("setOrderDetails", dataObject.data)
            delete dataObject.data
            context.commit('setOrderDetailsPaginateObject', dataObject)
            return Promise.resolve();
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async storeOrderDetail(context, payload = {orderDetailForm: null}) {
        let link = `${BASE_ORDER_DETAILS_LINK}/store`

        let _axios = util.makeAxiosFactory(link, "POST", payload.orderDetailForm)

        return _axios.then((response) => {

            return Promise.resolve(response.data);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async removeOrderDetail(context, payload = {orderDetailId: null}) {
        let link = `${BASE_ORDER_DETAILS_LINK}/${payload.orderDetailId}`

        let _axios = util.makeAxiosFactory(link, 'DELETE')

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async duplicateOrderDetail(context, payload = {orderDetailId: null}) {
        let link = `${BASE_ORDER_DETAILS_LINK}/duplicate/${payload.orderDetailId}`

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
    setOrderDetails(state, payload) {
        state.orderDetails = payload || [];
        localStorage.setItem('dodoors_orderDetails', JSON.stringify(payload));
    },
    setOrderDetailsPaginateObject(state, payload) {
        state.orderDetails_paginate_object = payload || [];
        localStorage.setItem('dodoors_orderDetails_paginate_object', JSON.stringify(payload));
    }
}

const orderDetailsModule = {
    state,
    mutations,
    actions,
    getters
}
export default orderDetailsModule;
