const state = () => ({
    products: {
        data: []
    },

    errors: [],

    new: {}
});

const getters = {
    getErrors: state => state.errors,
};

const actions = {
    setConfirmedRecord({ commit }) {
        return new Promise((resolve, reject) => {

        });
    },

    saveProduct({ commit }, data) {
        console.log(555, data)
        return new Promise((resolve, reject) => {
            axios
                .post('/products', data, { withCredentials: true })
                .then(response => {
                    resolve(response.data)
                })
                .catch(error => {
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
