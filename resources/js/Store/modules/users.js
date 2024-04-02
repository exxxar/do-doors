import util from './utilites';


const BASE_USERS_LINK = '/users'

let state = {
    users: [],
    users_paginate_object: null,
}

const getters = {
    getUsers: state => state.users || [],
    getUserById: (state) => (id) => {
        return state.users.find(item => item.id === id)
    },
    getUsersPaginateObject: state => state.users_paginate_object || null,
}

const actions = {
    async loadUsers(context, payload = {dataObject: null, page: 0, size: 50}) {
        let page = payload.page || 0
        let size = payload.size || 50

        let link = `${BASE_USERS_LINK}?page=${page}&size=${size}`
        let method = 'POST'
        let data = payload.dataObject

        let _axios = util.makeAxiosFactory(link, method, data)

        return _axios.then((response) => {
            let dataObject = response.data
            context.commit("setUsers", dataObject.data)
            delete dataObject.data
            context.commit('setUsersPaginateObject', dataObject)
            return Promise.resolve();
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async storeUser(context, payload = {userForm: null}) {
        let link = `${BASE_USERS_LINK}/store`

        let _axios = util.makeAxiosFactory(link, "POST", payload.userForm)

        return _axios.then((response) => {

            return Promise.resolve(response.data);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async removeUser(context, payload = {userId: null}) {
        let link = `${BASE_USERS_LINK}/${payload.userId}`

        let _axios = util.makeAxiosFactory(link, 'DELETE')

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async duplicateUser(context, payload = {userId: null}) {
        let link = `${BASE_USERS_LINK}/duplicate/${payload.userId}`

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
    setUsers(state, payload) {
        state.users = payload || [];
        localStorage.setItem('dodoors_users', JSON.stringify(payload));
    },
    setUsersPaginateObject(state, payload) {
        state.users_paginate_object = payload || [];
        localStorage.setItem('dodoors_users_paginate_object', JSON.stringify(payload));
    }
}

const usersModule = {
    state,
    mutations,
    actions,
    getters
}
export default usersModule;
