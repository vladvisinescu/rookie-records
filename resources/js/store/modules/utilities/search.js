const state = () => ({
    result: []
});

const getters = {
    getResult: (state) => state.result
};

const actions = {
    getProductsForSearch({ commit }, term) {
        return new Promise((resolve, reject) => {
            axios.get(route('shop.search'), {
                params: { term: term }
            }).then(response => {
                commit('setResults', response.data)
                resolve(response.data)
            }).catch(error => {
                reject(error.response.data)
            })
        })
    },

    clearResults({ commit }) {
        commit('clearResults')
    }
};

const mutations = {
    setResults(state, data) {
        state.result = data;
    },

    clearResults(state) {
        state.result = []
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
