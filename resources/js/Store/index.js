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
import orderDetails from './modules/order_details.js'
import promoCodes from './modules/promo_codes.js'
import roles from './modules/roles.js'
import permissions from './modules/permissions.js'
import users from './modules/users.js'
import services from './modules/services.js'

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
        promoCodes,
        roles,
        permissions,
        orderDetails,
        users,
        services
    }
})
