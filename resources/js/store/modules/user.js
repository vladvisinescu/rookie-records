const state = () => ({
    user: {},
    errors: {}
});

const getters = {
    getUser: (state) => state.user,
    getAddresses: (state) => state.user.addresses ?? null,
    getErrors: (state) => state.errors
};

const actions = {
    getUser({ commit }) {
        return new Promise((resolve, reject) => {
            axios.get(route('api.user.get')).then(response => {
                commit('setUser', response.data.data)
                resolve(response.data)
            }).catch(error => {
                reject(error.response.data)
            })
        })
    },

    updateUser({ commit }, data) {
        commit('setErrors', {})
        return new Promise((resolve, reject) => {
            axios.patch(route('api.user.update'), data, { withCredentials: true }).then(response => {
                resolve(response.data.data)
                commit('setUser', response.data.data)
            }).catch(error => {
                reject(error.response.data)
                commit('setErrors', error.response.data.errors)
            })
        })
    }
};

const mutations = {
    setUser(state, user) {
        state.user = user;
    },

    setErrors(state, errors) {
        state.errors = errors
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
