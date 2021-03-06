const state = () => ({
    addresses: [],
});

const getters = {
    allAddresses: (state) => state.addresses,
};

const actions = {
    getAddresses({ commit }, filters = {}) {
        return new Promise((resolve, reject) => {
            axios
                .get('/api/addresses', {
                    withCredentials: true
                })
                .then(response => {
                    commit('setAddresses', response.data)
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error.response.data)
                })
        })
    },

    saveAddress({ commit }, data) {
        return new Promise((resolve, reject) => {
            axios
                .post('/api/addresses', { ...data }, { withCredentials: true })
                .then(response => {
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error.response.data.errors)
                })
        })
    },
};

const mutations = {
    setAddresses(state, data) {
        state.addresses = data
    },
  };

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
