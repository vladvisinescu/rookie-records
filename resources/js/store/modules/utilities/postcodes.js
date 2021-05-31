const state = () => ({
    result: []
});

const getters = {
    getAddresses: (state) => state.result.addresses,
    getResult: (state) => state.result
};

const actions = {
    getAddressesForPostcode({ commit }, postcode) {
        return new Promise((resolve, reject) => {
            axios.get(route('api.addresses.lookup', postcode), {
                params: { 'api-key': process.env.MIX_POSTCODE_LOOKUP_KEY }
            }).then(response => {
                commit('setResults', response.data)
                resolve(response.data.data)
            }).catch(error => {
                reject(error.response.data)
            })
        })
    },

    clearResults({ commit }) {
        commit('deleteResults')
    }
};

const mutations = {
    setResults(state, data) {
        state.result = data;
    },

    deleteResults(state) {
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
