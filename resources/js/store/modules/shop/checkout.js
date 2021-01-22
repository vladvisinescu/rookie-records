const state = () => ({
    products: [],
});

const getters = {
    allProducts: (state) => state.products,
    cartTotal: (state) => {
        //
    }
};

const actions = {
    getProducts({ commit }, filters = {}) {
        return new Promise((resolve, reject) => {
            axios
                .get('/shop/checkout/api/products', {
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
