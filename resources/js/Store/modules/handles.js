import util from './utilites';


const BASE_HANDLES_LINK = '/handles'

let state = {
    handles: [],
    handles_paginate_object: null,
}

const getters = {
    getHandles: state => state.handles || [],
    getHandleById: (state) => (id) => {
        return state.handles.find(item => item.id === id)
    },
    getHandlesPaginateObject: state => state.handles_paginate_object || null,
}

const actions = {
    async importHandlesFromGoogle(context, payload = {importForm: null}) {
        let link = `${BASE_HANDLES_LINK}/import-from-google`

        let _axios = util.makeAxiosFactory(link, "POST", payload.importForm)

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async importHandlesFromExcel(context, payload = {importForm: null}) {
        let link = `${BASE_HANDLES_LINK}/import-from-excel`

        let _axios = util.makeAxiosFactory(link, "POST", payload.importForm)

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async loadHandles(context, payload = {dataObject: null, page: 0, size: 50}) {
        let page = payload.page || 0
        let size = payload.size || 50

        let link = `${BASE_HANDLES_LINK}?page=${page}&size=${size}`
        let method = 'POST'
        let data = payload.dataObject

        let _axios = util.makeAxiosFactory(link, method, data)

        return _axios.then((response) => {
            let dataObject = response.data
            context.commit("setHandles", dataObject.data)
            delete dataObject.data
            context.commit('setHandlesPaginateObject', dataObject)
            return Promise.resolve();
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },


    async fastStoreHandles(context, payload = {handles: null}) {
        let link = `${BASE_HANDLES_LINK}/fast-store`

        let _axios = util.makeAxiosFactory(link, "POST", payload)

        return _axios.then((response) => {

            return Promise.resolve(response.data);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async storeHandle(context, payload = {handleForm: null}) {
        let link = `${BASE_HANDLES_LINK}/store`

        let _axios = util.makeAxiosFactory(link, "POST", payload.handleForm)

        return _axios.then((response) => {

            return Promise.resolve(response.data);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async removeHandle(context, payload = {handleId: null}) {
        let link = `${BASE_HANDLES_LINK}/${payload.handleId}`

        let _axios = util.makeAxiosFactory(link, 'DELETE')

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async duplicateHandle(context, payload = {handleId: null}) {
        let link = `${BASE_HANDLES_LINK}/duplicate/${payload.handleId}`

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
    setHandles(state, payload) {
        state.handles = payload || [];
        localStorage.setItem('dodoors_handles', JSON.stringify(payload));
    },
    setHandlesPaginateObject(state, payload) {
        state.handles_paginate_object = payload || [];
        localStorage.setItem('dodoors_handles_paginate_object', JSON.stringify(payload));
    }
}

const handlesModule = {
    state,
    mutations,
    actions,
    getters
}
export default handlesModule;
