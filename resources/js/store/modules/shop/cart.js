const state = () => ({
    products: [],
});

const getters = {
    allProducts: (state) => state.products,
};

const actions = {
    getProducts({ commit }, filters = {}) {
        return new Promise((resolve, reject) => {
            axios
                .get('/shop/vinyl/api', {
                    params: { ...filters }
                }, { withCredentials: true })
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
