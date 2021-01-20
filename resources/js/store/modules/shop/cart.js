const state = () => ({
    products: [],
});

const getters = {
    allProducts: (state) => state.products,
    cartTotal: (state) => {

        if (!state.products.length) {
            return 0;
        }

        return state.products.map(item => {
            return item.price * item.quantity
        }).reduce((accumulator, currentValue) => accumulator + currentValue)
    }
};

const actions = {

    addToCart({ commit }, data) {
        return new Promise((resolve, reject) => {
            axios
                .post('/shop/cart', data, { withCredentials: true })
                .then(response => {
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error.response.data)
                })
        })
    },

    removeFromCart({ commit }, product) {
        return new Promise((resolve, reject) => {
            axios
                .delete('/shop/cart/' + product.id, { withCredentials: true })
                .then(response => {
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error.response.data)
                })
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
                .catch(error => {
                    reject(error.response.data)
                })
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
