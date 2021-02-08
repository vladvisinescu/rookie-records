const state = () => ({
    contacts: [],
});

const getters = {
    allContacts: (state) => state.contacts,
};

const actions = {
    getContacts({ commit }, filters = {}) {
        return new Promise((resolve, reject) => {
            axios
                .get('/api/contacts', {
                    withCredentials: true
                })
                .then(response => {
                    commit('setContacts', response.data)
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
                .post('/api/contacts', { ...data }, { withCredentials: true })
                .then(response => {
                    console.log(response.data)
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error.response.data)
                })
        })
    },
};

const mutations = {
    setContacts(state, data) {
        state.contacts = data
    },
  };

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
