import util from "./utilites";

const BASE_CART_LINK = '/calc'

const state = {
    items: localStorage.getItem('dodoors_basket') == null ?
        [] : JSON.parse(localStorage.getItem('dodoors_basket')),
}

// getters
const getters = {

    cartProducts: (state, getters, rootState) => {
        return state.items;
    },
    cartTotalCount: (state, getters) => {

        if (state.items == null)
            return 0;

        if (state.items.length === 0)
            return 0;

        let sum = 0;
        state.items.forEach((item) => {
            sum += (item.quantity || 0)
        });
        return sum
    },
    cartTotalPrice: (state, getters) => {
        if (state.items == null)
            return 0;

        if (state.items.length === 0)
            return 0;

        let sum = 0;

        state.items.forEach((item) => {
            sum += (item.product.price || 0) * (item.quantity || 0)
        });
        return sum
    }
}

// actions
const actions = {
    addProductToCart({state, commit}, product) {
        commit('pushProductToCart', product);
    },
    setQuantity({state, commit}, prod) {
        commit('setItemQuantity', prod);
    },
    incQuantity({state, commit}, id) {
        commit('incrementItemQuantity', id);
    },
    decQuantity({state, commit}, id) {
        commit('decrementItemQuantity', id);
    },
    removeProduct({state, commit}, id) {
        commit('removeItem', id);
    },
    clearCart({state, commit}) {
        commit('clearAllItems');
    },

    async downloadExcel(context, payload = {cardData: null}) {
        let link = `${BASE_CART_LINK}/download-excel`

        let _axios = util.makeAxiosFactory(link, "POST", payload.cardData, {
            responseType: 'blob'
        })

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
    async checkoutItems(context, payload = {clientForm: null}) {
        let link = `${BASE_CART_LINK}/checkout`

        let _axios = util.makeAxiosFactory(link, "POST", payload.clientForm)

        return _axios.then((response) => {
            return Promise.resolve(response.data);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },
}

// mutations
const mutations = {

    pushProductToCart(state, product) {
        const cartItem = state.items.find(item => item.product.id === product.id)
        if (!cartItem)
            state.items.push({
                product,
                quantity: product.count || 1
            })
        else {
            cartItem.product = product
            cartItem.quantity = product.count || 1
        }


        localStorage.setItem('dodoors_basket', JSON.stringify(state.items));
    },


    incrementItemQuantity(state, id) {
        const cartItem = state.items.find(item => item.product.id === id)
        cartItem.quantity++

        localStorage.setItem('dodoors_basket', JSON.stringify(state.items));
    },
    setItemQuantity(state, payload) {
        const cartItem = state.items.find(item => item.product.id === payload.id)
        cartItem.quantity = payload.quantity;
        localStorage.setItem('dodoors_basket', JSON.stringify(state.items));
    },

    decrementItemQuantity(state, id) {
        const cartItem = state.items.find(item => item.product.id === id)
        if (cartItem.quantity > 1)
            cartItem.quantity--;

        localStorage.setItem('dodoors_basket', JSON.stringify(state.items));
    },
    removeItem(state, id) {
        let tmp = state.items.filter((item) => item.product.id !== id);
        state.items = tmp

        localStorage.setItem('dodoors_basket', JSON.stringify(state.items));
    },

    clearAllItems(state) {
        state.items = []
        localStorage.setItem('dodoors_basket', JSON.stringify(state.items));
    },
    setCartItems(state, items) {
        state.items = items

        localStorage.setItem('dodoors_basket', JSON.stringify(state.items));
    },

}


const cardModule = {
    state,
    mutations,
    actions,
    getters
}
export default cardModule;
