import util from './utilites';


const BASE_PERMISSIONS_LINK = '/permissions'

let state = {
    permissions: [],
    permissions_paginate_object: null,
}

const getters = {
    getPermissions: state => state.permissions || [],
    getPermissionById: (state) => (id) => {
        return state.permissions.find(item => item.id === id)
    },
    getPermissionsPaginateObject: state => state.permissions_paginate_object || null,
}

const actions = {
    async loadPermissions(context, payload = {dataObject: null, page: 0, size: 50}) {
        let page = payload.page || 0
        let size = payload.size || 50

        let link = `${BASE_PERMISSIONS_LINK}?page=${page}&size=${size}`
        let method = 'POST'
        let data = payload.dataObject

        let _axios = util.makeAxiosFactory(link, method, data)

        return _axios.then((response) => {
            let dataObject = response.data
            context.commit("setPermissions", dataObject.data)
            delete dataObject.data
            context.commit('setPermissionsPaginateObject', dataObject)
            return Promise.resolve();
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async storePermission(context, payload = {permissionForm: null}) {
        let link = `${BASE_PERMISSIONS_LINK}/store`

        let _axios = util.makeAxiosFactory(link, "POST", payload.permissionForm)

        return _axios.then((response) => {

            return Promise.resolve(response.data);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async removePermission(context, payload = {permissionId: null}) {
        let link = `${BASE_PERMISSIONS_LINK}/${payload.permissionId}`

        let _axios = util.makeAxiosFactory(link, 'DELETE')

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async duplicatePermission(context, payload = {permissionId: null}) {
        let link = `${BASE_PERMISSIONS_LINK}/duplicate/${payload.permissionId}`

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
    setPermissions(state, payload) {
        state.permissions = payload || [];
        localStorage.setItem('dodoors_permissions', JSON.stringify(payload));
    },
    setPermissionsPaginateObject(state, payload) {
        state.permissions_paginate_object = payload || [];
        localStorage.setItem('dodoors_permissions_paginate_object', JSON.stringify(payload));
    }
}

const permissionsModule = {
    state,
    mutations,
    actions,
    getters
}
export default permissionsModule;
