import util from './utilites';


const BASE_CLIENTS_LINK = '/clients'

let state = {
    clients: [],
    clients_paginate_object: null,
}

const getters = {
    getClients: state => state.clients || [],
    getClientById: (state) => (id) => {
        return state.clients.find(item => item.id === id)
    },
    getClientsPaginateObject: state => state.clients_paginate_object || null,
}

const actions = {
    async loadClients(context, payload = {dataObject: null, page: 0, size: 50}) {
        let page = payload.page || 0
        let size = payload.size || 50

        let link = `${BASE_CLIENTS_LINK}?page=${page}&size=${size}`
        let method = 'POST'
        let data = payload.dataObject

        let _axios = util.makeAxiosFactory(link, method, data)

        return _axios.then((response) => {
            let dataObject = response.data
            context.commit("setClients", dataObject.data)
            delete dataObject.data
            context.commit('setClientsPaginateObject', dataObject)
            return Promise.resolve();
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async loadSelfClients(context) {
        let link = `${BASE_CLIENTS_LINK}/self-list`
        let method = 'GET'

        let _axios = util.makeAxiosFactory(link, method)

        return _axios.then((response) => {
            let dataObject = response.data
            return Promise.resolve(dataObject);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async requestByBik(context, payload = {bik: null}) {
        let link = `${BASE_CLIENTS_LINK}/request-by-bik`

        let _axios = util.makeAxiosFactory(link, "POST", payload)

        return _axios.then((response) => {

            return Promise.resolve(response.data);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async requestByInn(context, payload = {inn: null}) {
        let link = `${BASE_CLIENTS_LINK}/request-by-inn`

        let _axios = util.makeAxiosFactory(link, "POST", payload)

        return _axios.then((response) => {

            return Promise.resolve(response.data);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async storeClient(context, payload = {clientForm: null}) {
        let link = `${BASE_CLIENTS_LINK}/store`

        let _axios = util.makeAxiosFactory(link, "POST", payload.clientForm)

        return _axios.then((response) => {

            return Promise.resolve(response.data);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async removeClient(context, payload = {clientId: null}) {
        let link = `${BASE_CLIENTS_LINK}/${payload.clientId}`

        let _axios = util.makeAxiosFactory(link, 'DELETE')

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async duplicateClient(context, payload = {clientId: null}) {
        let link = `${BASE_CLIENTS_LINK}/duplicate/${payload.clientId}`

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
    setClients(state, payload) {
        state.clients = payload || [];
        localStorage.setItem('dodoors_clients', JSON.stringify(payload));
    },
    setClientsPaginateObject(state, payload) {
        state.clients_paginate_object = payload || [];
        localStorage.setItem('dodoors_clients_paginate_object', JSON.stringify(payload));
    }
}

const clientsModule = {
    state,
    mutations,
    actions,
    getters
}
export default clientsModule;
