const state = () => ({
    products: {
        all: []
    },

    errors: [],

    new: {}
});

const getters = {
    getErrors: state => state.errors,
    getProducts: state => state.products.all,
};

const actions = {
    setConfirmedRecord({ commit }) {
        return new Promise((resolve, reject) => {

        });
    },

    getAllProducts({ commit }, filters = {}) {
        return new Promise((resolve, reject) => {
            axios
                .get('/products', { params: { ...filters } })
                .then(response => {
                    commit('setProductList', response.data)
                    resolve(response.data)
                }).catch(error => {
                    reject(error.response.data.errors)
                })
        })
    },

    saveProduct({ commit }, data) {
        return new Promise((resolve, reject) => {
            axios
                .post('/products', data, { withCredentials: true })
                .then(response => {
                    resolve(response.data)
                }).catch(error => {
                    commit('setErrors', error.response.data.errors)
                    reject(error.response.data.errors)
                })
        })
    },

    deleteProduct({ commit }, productID) {
        return new Promise((resolve, reject) => {
            axios
                .delete('/products/' + productID, { withCredentials: true })
                .then(response => {
                    resolve(response.data)
                }).catch(error => {
                commit('setErrors', error.response.data.errors)
                reject(error.response.data.errors)
            })
        })
    },
};

const mutations = {
    setErrors(state, data) {
        state.errors = data
    },

    setProductList(state, data) {
        state.products.all = data
    },

    setConfirmedRecord(state, data) {
        state.new = data
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
