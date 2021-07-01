const state = () => ({
    user: {
        roles: []
    },
    errors: []
});

const getters = {
    getUser: (state) => state.user,
    getAddresses: (state) => state.user.addresses ?? null,
    getContactFormErrors: (state) => state.errors,
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
    },

    submitContact({ commit }, data) {
        return new Promise((resolve, reject) => {
            axios.post(route('home.contact-us.submit'), { ...data }, { withCredentials: true }).then(response => {
                resolve(response.data.data)
                commit('setUser', response.data.data)
            }).catch(error => {
                commit('setErrors', error.response.data.errors)
                reject(error.response.data)
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
