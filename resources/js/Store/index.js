import {createStore} from 'vuex'
import cart from './modules/cart.js'
import dictionaries from './modules/dictionaries.js'
import materials from './modules/materials.js'
import sizes from './modules/sizes.js'
import handles from './modules/handles.js'
import hinges from './modules/hinges.js'
import colors from './modules/colors.js'
import door_variants from './modules/door_variants.js'
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
        hinges,
        door_variants,
        colors,
        users
    }
})
