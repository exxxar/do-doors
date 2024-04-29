import util from './utilites';


const BASE_ROLES_LINK = '/roles'

let state = {
    roles: [],
    roles_paginate_object: null,
}

const getters = {
    getRoles: state => state.roles || [],
    getRoleById: (state) => (id) => {
        return state.roles.find(item => item.id === id)
    },
    getRolesPaginateObject: state => state.roles_paginate_object || null,
}

const actions = {
    async loadRoles(context, payload = {dataObject: null, page: 0, size: 50}) {
        let page = payload.page || 0
        let size = payload.size || 50

        let link = `${BASE_ROLES_LINK}?page=${page}&size=${size}`
        let method = 'POST'
        let data = payload.dataObject

        let _axios = util.makeAxiosFactory(link, method, data)

        return _axios.then((response) => {
            let dataObject = response.data
            context.commit("setRoles", dataObject.data)
            delete dataObject.data
            context.commit('setRolesPaginateObject', dataObject)
            return Promise.resolve();
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async storeRole(context, payload = {roleForm: null}) {
        let link = `${BASE_ROLES_LINK}/store`

        let _axios = util.makeAxiosFactory(link, "POST", payload.roleForm)

        return _axios.then((response) => {

            return Promise.resolve(response.data);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async removeRole(context, payload = {roleId: null}) {
        let link = `${BASE_ROLES_LINK}/${payload.roleId}`

        let _axios = util.makeAxiosFactory(link, 'DELETE')

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async duplicateRole(context, payload = {roleId: null}) {
        let link = `${BASE_ROLES_LINK}/duplicate/${payload.roleId}`

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
    setRoles(state, payload) {
        state.roles = payload || [];
        localStorage.setItem('dodoors_roles', JSON.stringify(payload));
    },
    setRolesPaginateObject(state, payload) {
        state.roles_paginate_object = payload || [];
        localStorage.setItem('dodoors_roles_paginate_object', JSON.stringify(payload));
    }
}

const rolesModule = {
    state,
    mutations,
    actions,
    getters
}
export default rolesModule;
