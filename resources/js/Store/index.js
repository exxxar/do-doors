import {createStore} from 'vuex'
import cart from './modules/cart.js'
import dictionaries from './modules/dictionaries.js'
import materials from './modules/materials.js'
import sizes from './modules/sizes.js'
import handles from './modules/handles.js'
import clients from './modules/clients.js'
import orders from './modules/orders.js'
import users from './modules/users.js'

export default createStore({
    state: {
        errors: [],
    },
    getters: {
        getErrors: state => state.errors || [],
    },
    actions: {

    },
    mutations: {
        setErrors(state, payload) {
            state.errors = payload || [];
        },
    },
    modules: {
        cart,
        dictionaries,
        materials,
        sizes,
        clients,
        orders,
        handles,
        users
    }
})
