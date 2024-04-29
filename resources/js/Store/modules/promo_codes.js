import util from './utilites';


const BASE_PROMO_CODES_LINK = '/promo-codes'

let state = {
    promo_codes: [],
    promo_codes_paginate_object: null,
}

const getters = {
    getPromoCodes: state => state.promo_codes || [],
    getPromoCodeById: (state) => (id) => {
        return state.promo_codes.find(item => item.id === id)
    },
    getPromoCodesPaginateObject: state => state.promo_codes_paginate_object || null,
}

const actions = {
    async findPromoCode(context, payload = {code: null}) {
        let page = payload.page || 0
        let size = payload.size || 50

        let link = `${BASE_PROMO_CODES_LINK}/find-promo`
        let method = 'POST'
        let data = payload.dataObject

        let _axios = util.makeAxiosFactory(link, method, payload)

        return _axios.then((response) => {
            let dataObject = response.data
            return Promise.resolve(dataObject);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async loadPromoCodes(context, payload = {dataObject: null, page: 0, size: 50}) {
        let page = payload.page || 0
        let size = payload.size || 50

        let link = `${BASE_PROMO_CODES_LINK}?page=${page}&size=${size}`
        let method = 'POST'
        let data = payload.dataObject

        let _axios = util.makeAxiosFactory(link, method, data)

        return _axios.then((response) => {
            let dataObject = response.data
            context.commit("setPromoCodes", dataObject.data)
            delete dataObject.data
            context.commit('setPromoCodesPaginateObject', dataObject)
            return Promise.resolve();
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async storePromoCode(context, payload = {promoCodeForm: null}) {
        let link = `${BASE_PROMO_CODES_LINK}/store`

        let _axios = util.makeAxiosFactory(link, "POST", payload.promoCodeForm)

        return _axios.then((response) => {

            return Promise.resolve(response.data);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async removePromoCode(context, payload = {promoCodeId: null}) {
        let link = `${BASE_PROMO_CODES_LINK}/${payload.promoCodeId}`

        let _axios = util.makeAxiosFactory(link, 'DELETE')

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async duplicatePromoCode(context, payload = {promoCodeId: null}) {
        let link = `${BASE_PROMO_CODES_LINK}/duplicate/${payload.promoCodeId}`

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
    setPromoCodes(state, payload) {
        state.promo_codes = payload || [];
        localStorage.setItem('dodoors_promo_codes', JSON.stringify(payload));
    },
    setPromoCodesPaginateObject(state, payload) {
        state.promo_codes_paginate_object = payload || [];
        localStorage.setItem('dodoors_promo_codes_paginate_object', JSON.stringify(payload));
    }
}

const promo_codesModule = {
    state,
    mutations,
    actions,
    getters
}
export default promo_codesModule;
