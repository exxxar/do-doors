import util from './utilites';


const BASE_MATERIALS_LINK = '/materials'

let state = {
    materials: [],
    materials_paginate_object: null,
}

const getters = {
    getMaterials: state => state.materials || [],
    getMaterialById: (state) => (id) => {
        return state.materials.find(item => item.id === id)
    },
    getMaterialsPaginateObject: state => state.materials_paginate_object || null,
}

const actions = {
    async loadMaterials(context, payload = {dataObject: null, page: 0, size: 50}) {
        let page = payload.page || 0
        let size = payload.size || 50

        let link = `${BASE_MATERIALS_LINK}?page=${page}&size=${size}`
        let method = 'POST'
        let data = payload.dataObject

        let _axios = util.makeAxiosFactory(link, method, data)

        return _axios.then((response) => {
            let dataObject = response.data
            context.commit("setMaterials", dataObject.data)
            delete dataObject.data
            context.commit('setMaterialsPaginateObject', dataObject)
            return Promise.resolve();
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async storeMaterial(context, payload = {materialForm: null}) {
        let link = `${BASE_MATERIALS_LINK}/store`

        let _axios = util.makeAxiosFactory(link,"POST", payload.materialForm)

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async removeMaterial(context, payload= {materialId: null}){
        let link = `${BASE_MATERIALS_LINK}/${payload.materialId}`

        let _axios = util.makeAxiosFactory(link, 'DELETE')

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async duplicateMaterial(context, payload= {materialId: null}){
        let link = `${BASE_MATERIALS_LINK}/duplicate/${payload.materialId}`

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
    setMaterials(state, payload) {
        state.materials = payload || [];
        localStorage.setItem('dodoors_materials', JSON.stringify(payload));
    },
    setMaterialsPaginateObject(state, payload) {
        state.materials_paginate_object = payload || [];
        localStorage.setItem('dodoors_materials_paginate_object', JSON.stringify(payload));
    }
}

const materialsModule = {
    state,
    mutations,
    actions,
    getters
}
export default materialsModule;
