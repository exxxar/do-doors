import util from './utilites';


const BASE_SIZES_LINK = '/sizes'

let state = {
    sizes: [],
    sizes_paginate_object: null,
}

const getters = {
    getSizes: state => state.sizes || [],
    getSizeById: (state) => (id) => {
        return state.sizes.find(item => item.id === id)
    },
    getSizesPaginateObject: state => state.sizes_paginate_object || null,
}

const actions = {

    async loadFormattedSizes(context) {

        let link = `${BASE_SIZES_LINK}/formatted`
        let method = 'POST'


        let _axios = util.makeAxiosFactory(link, method)

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async loadSizes(context, payload = {dataObject: null, page: 0, size: 50}) {
        let page = payload.page || 0
        let size = payload.size || 50

        let link = `${BASE_SIZES_LINK}?page=${page}&size=${size}`
        let method = 'POST'
        let data = payload.dataObject

        let _axios = util.makeAxiosFactory(link, method, data)

        return _axios.then((response) => {
            let dataObject = response.data
            context.commit("setSizes", dataObject.data)
            delete dataObject.data
            context.commit('setSizesPaginateObject', dataObject)
            return Promise.resolve();
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },

    async updateSizeParam(context, payload = {dataObject: null}) {
        let link = `${BASE_SIZES_LINK}/update-param`

        let _axios = util.makeAxiosFactory(link, "POST", payload.dataObject)

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            if (err.response.data)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async generateSizes(context, payload = {generateForm: null}) {
        let link = `${BASE_SIZES_LINK}/generate`

        let _axios = util.makeAxiosFactory(link, "POST", payload.generateForm)

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            if (err.response.data)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async recountPrice(context, payload = {recountForm: null}) {
        let link = `${BASE_SIZES_LINK}/recount`

        let _axios = util.makeAxiosFactory(link, "POST", payload.recountForm)

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            if (err.response.data)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },

    async storeSize(context, payload = {sizeForm: null}) {
        let link = `${BASE_SIZES_LINK}/store`

        let _axios = util.makeAxiosFactory(link, "POST", payload.sizeForm)

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async removeSize(context, payload = {sizeId: null}) {
        let link = `${BASE_SIZES_LINK}/${payload.sizeId}`

        let _axios = util.makeAxiosFactory(link, 'DELETE')

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async duplicateSize(context, payload = {sizeId: null}) {
        let link = `${BASE_SIZES_LINK}/duplicate/${payload.sizeId}`

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
    setSizes(state, payload) {
        state.sizes = payload || [];
        localStorage.setItem('dodoors_sizes', JSON.stringify(payload));
    },
    setSizesPaginateObject(state, payload) {
        state.sizes_paginate_object = payload || [];
        localStorage.setItem('dodoors_sizes_paginate_object', JSON.stringify(payload));
    }
}

const sizesModule = {
    state,
    mutations,
    actions,
    getters
}
export default sizesModule;
