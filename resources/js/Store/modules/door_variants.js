import util from './utilites';


const BASE_DOOR_VARIANTS_LINK = '/door-variants'

let state = {
    door_variants: [],
    door_variants_paginate_object: null,
}

const getters = {
    getDoorVariants: state => state.door_variants || [],
    getDoorVariantById: (state) => (id) => {
        return state.door_variants.find(item => item.id === id)
    },
    getDoorVariantsPaginateObject: state => state.door_variants_paginate_object || null,
}

const actions = {
    async loadDoorVariants(context, payload = {dataObject: null, page: 0, size: 50}) {
        let page = payload.page || 0
        let size = payload.size || 50

        let link = `${BASE_DOOR_VARIANTS_LINK}?page=${page}&size=${size}`
        let method = 'POST'
        let data = payload.dataObject

        let _axios = util.makeAxiosFactory(link, method, data)

        return _axios.then((response) => {
            let dataObject = response.data
            context.commit("setDoorVariants", dataObject.data)
            delete dataObject.data
            context.commit('setDoorVariantsPaginateObject', dataObject)
            return Promise.resolve();
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async storeDoorVariant(context, payload = {doorVariantForm: null}) {
        let link = `${BASE_DOOR_VARIANTS_LINK}/store`

        let _axios = util.makeAxiosFactory(link, "POST", payload.doorVariantForm)

        return _axios.then((response) => {

            return Promise.resolve(response.data);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async removeDoorVariant(context, payload = {doorVariantId: null}) {
        let link = `${BASE_DOOR_VARIANTS_LINK}/${payload.doorVariantId}`

        let _axios = util.makeAxiosFactory(link, 'DELETE')

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async duplicateDoorVariant(context, payload = {doorVariantId: null}) {
        let link = `${BASE_DOOR_VARIANTS_LINK}/duplicate/${payload.doorVariantId}`

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
    setDoorVariants(state, payload) {
        state.door_variants = payload || [];
        localStorage.setItem('dodoors_door_variants', JSON.stringify(payload));
    },
    setDoorVariantsPaginateObject(state, payload) {
        state.door_variants_paginate_object = payload || [];
        localStorage.setItem('dodoors_door_variants_paginate_object', JSON.stringify(payload));
    }
}

const door_variantsModule = {
    state,
    mutations,
    actions,
    getters
}
export default door_variantsModule;
