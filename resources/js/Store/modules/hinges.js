import util from './utilites';


const BASE_HINGES_LINK = '/hinges'

let state = {
    hinges: [],
    hinges_paginate_object: null,
}

const getters = {
    getHinges: state => state.hinges || [],
    getHingeById: (state) => (id) => {
        return state.hinges.find(item => item.id === id)
    },
    getHingesPaginateObject: state => state.hinges_paginate_object || null,
}

const actions = {
    async loadHinges(context, payload = {dataObject: null, page: 0, size: 50}) {
        let page = payload.page || 0
        let size = payload.size || 50

        let link = `${BASE_HINGES_LINK}?page=${page}&size=${size}`
        let method = 'POST'
        let data = payload.dataObject

        let _axios = util.makeAxiosFactory(link, method, data)

        return _axios.then((response) => {
            let dataObject = response.data
            context.commit("setHinges", dataObject.data)
            delete dataObject.data
            context.commit('setHingesPaginateObject', dataObject)
            return Promise.resolve();
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async storeHinge(context, payload = {hingeForm: null}) {
        let link = `${BASE_HINGES_LINK}/store`

        let _axios = util.makeAxiosFactory(link, "POST", payload.hingeForm)

        return _axios.then((response) => {

            return Promise.resolve(response.data);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async removeHinge(context, payload = {hingeId: null}) {
        let link = `${BASE_HINGES_LINK}/${payload.hingeId}`

        let _axios = util.makeAxiosFactory(link, 'DELETE')

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async duplicateHinge(context, payload = {hingeId: null}) {
        let link = `${BASE_HINGES_LINK}/duplicate/${payload.hingeId}`

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
    setHinges(state, payload) {
        state.hinges = payload || [];
        localStorage.setItem('dodoors_hinges', JSON.stringify(payload));
    },
    setHingesPaginateObject(state, payload) {
        state.hinges_paginate_object = payload || [];
        localStorage.setItem('dodoors_hinges_paginate_object', JSON.stringify(payload));
    }
}

const hingesModule = {
    state,
    mutations,
    actions,
    getters
}
export default hingesModule;
