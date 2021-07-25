import analytics from "../../../lib/analytics";

const state = () => ({
    products: [],
});

const getters = {
    allProducts: (state) => state.products,
    cartTotal: (state) => {
        if (state.products.length < 1) {
            return 0;
        }

        return _(state.products).map((item) => item.price * item.quantity).sum().toFixed(2)
    }
};

const actions = {

    addToCart({ commit }, data) {
        return new Promise((resolve, reject) => {
            axios
                .post('/shop/cart', data, { withCredentials: true })
                .then(response => {
                    analytics.gAddToCart(response.data.product)
                    resolve(response.data)
                })
                .catch(error => reject(error.response))
        })
    },

    removeFromCart({ commit }, id) {
        return new Promise((resolve, reject) => {
            axios
                .delete('/shop/cart/' + id, { withCredentials: true })
                .then(response => {
                    analytics.gRemoveFromCart(response.data.product)
                    resolve(response.data)
                })
                .catch(error => reject(error.response))
        })
    },

    getCartSession({ commit }) {
        return new Promise((resolve, reject) => {
            axios
                .get('/shop/cart', { withCredentials: true })
                .then(response => {
                    commit('setProducts', response.data)
                    resolve(response.data)
                })
                .catch(error => reject(error.response.data))
        })
    },

    getProducts({ commit }, filters = {}) {
        return new Promise((resolve, reject) => {
            axios
                .get('/shop/vinyl/api', {
                    params: { ...filters },
                    withCredentials: true
                })
                .then(response => {
                    commit('setProducts', response.data)
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error.response.data)
                })
        })
    },
};

const mutations = {
    setProducts(state, data) {
        state.products = data
    },
  };

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
