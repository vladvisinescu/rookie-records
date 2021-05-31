const state = () => ({
    categories: []
});

const getters = {
    allCategories: (state) => state.categories,
};

const actions = {
    getCategories({ commit }) {
        return new Promise((resolve, reject) => {
            axios
                .get('/api/categories', { withCredentials: true })
                .then(response => {
                    commit('setCategories', response.data)
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error.response.data)
                })
        })
    },
};

const mutations = {
    setCategories(state, data) {
        state.categories = data
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
