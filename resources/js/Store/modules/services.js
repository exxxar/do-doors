import util from './utilites';


const BASE_SERVICE_LINK = '/services'

let state = {
    services: [],
    services_paginate_object: null,
}

const getters = {
    getServices: state => state.services || [],
    getServiceById: (state) => (id) => {
        return state.services.find(item => item.id === id)
    },
    getServicesPaginateObject: state => state.services_paginate_object || null,
}

const actions = {
    async importServicesFromMoySklad(context, payload ) {
        let link = `${BASE_SERVICE_LINK}/import-from-moysklad`

        let _axios = util.makeAxiosFactory(link, "POST", payload)

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async loadServices(context, payload = {dataObject: null, page: 0, size: 50}) {
        let page = payload.page || 0
        let size = payload.size || 50

        let link = `${BASE_SERVICE_LINK}?page=${page}&size=${size}`
        let method = 'POST'
        let data = payload.dataObject

        let _axios = util.makeAxiosFactory(link, method, data)

        return _axios.then((response) => {
            let dataObject = response.data
            context.commit("setServices", dataObject.data)
            delete dataObject.data
            context.commit('setServicesPaginateObject', dataObject)
            return Promise.resolve();
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },

    async loadServicesByType(context, payload = {type:null}) {
        let link = `${BASE_SERVICE_LINK}/by-type`
        let method = 'POST'

        let _axios = util.makeAxiosFactory(link, method, payload)

        return _axios.then((response) => {
            let dataObject = response.data
            return Promise.resolve(dataObject);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async storeService(context, payload = {serviceForm: null}) {
        let link = `${BASE_SERVICE_LINK}/store`

        let _axios = util.makeAxiosFactory(link, "POST", payload.serviceForm)

        return _axios.then((response) => {

            return Promise.resolve(response.data);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async removeService(context, payload = {serviceId: null}) {
        let link = `${BASE_SERVICE_LINK}/${payload.serviceId}`

        let _axios = util.makeAxiosFactory(link, 'DELETE')

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async duplicateService(context, payload = {serviceId: null}) {
        let link = `${BASE_SERVICE_LINK}/duplicate/${payload.serviceId}`

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
    setServices(state, payload) {
        state.services = payload || [];
        localStorage.setItem('dodoors_services', JSON.stringify(payload));
    },
    setServicesPaginateObject(state, payload) {
        state.services_paginate_object = payload || [];
        localStorage.setItem('dodoors_services_paginate_object', JSON.stringify(payload));
    }
}

const servicesModule = {
    state,
    mutations,
    actions,
    getters
}
export default servicesModule;
