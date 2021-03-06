const state = () => ({
    user: {},
});

const getters = {
    getUser: (state) => state.user,
};

const actions = {
    getUser({ commit }) {
        return new Promise((resolve, reject) => {
            axios.get('/api/user').then(response => {
                commit('setUser', response.data)
                resolve(response.data)
            }).catch(error => {
                reject(error.response.data)
            })
        })
    }
};

const mutations = {
    setUser(state, user) {
        state.user = user;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
