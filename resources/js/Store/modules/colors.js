import util from './utilites';


const BASE_COLORS_LINK = '/colors'

let state = {
    colors: [],
    colors_paginate_object: null,
}

const getters = {
    getColors: state => state.colors || [],
    getColorById: (state) => (id) => {
        return state.colors.find(item => item.id === id)
    },
    getColorsPaginateObject: state => state.colors_paginate_object || null,
}

const actions = {
    async loadColors(context, payload = {dataObject: null, page: 0, size: 50}) {
        let page = payload.page || 0
        let size = payload.size || 50

        let link = `${BASE_COLORS_LINK}?page=${page}&size=${size}`
        let method = 'POST'
        let data = payload.dataObject

        let _axios = util.makeAxiosFactory(link, method, data)

        return _axios.then((response) => {
            let dataObject = response.data
            context.commit("setColors", dataObject.data)
            delete dataObject.data
            context.commit('setColorsPaginateObject', dataObject)
            return Promise.resolve();
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async storeColor(context, payload = {colorForm: null}) {
        let link = `${BASE_COLORS_LINK}/store`

        let _axios = util.makeAxiosFactory(link, "POST", payload.colorForm)

        return _axios.then((response) => {

            return Promise.resolve(response.data);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async removeColor(context, payload = {colorId: null}) {
        let link = `${BASE_COLORS_LINK}/${payload.colorId}`

        let _axios = util.makeAxiosFactory(link, 'DELETE')

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async duplicateColor(context, payload = {colorId: null}) {
        let link = `${BASE_COLORS_LINK}/duplicate/${payload.colorId}`

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
    setColors(state, payload) {
        state.colors = payload || [];
        localStorage.setItem('dodoors_colors', JSON.stringify(payload));
    },
    setColorsPaginateObject(state, payload) {
        state.colors_paginate_object = payload || [];
        localStorage.setItem('dodoors_colors_paginate_object', JSON.stringify(payload));
    }
}

const colorsModule = {
    state,
    mutations,
    actions,
    getters
}
export default colorsModule;
