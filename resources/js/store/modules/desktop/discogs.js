const state = () => ({
    term: ''
});

const getters = {
    // currentUser: (state) => state.currentUser,
};

const actions = {

    getCurrentUser({ commit }) {
        return new Promise((resolve, reject) => {

        });
    },

    searchRecord({ commit }, term) {
        return new Promise((resolve, reject) => {
            axios
                .post('/search', { term: term }, { withCredentials: true })
                .then(response => {
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error.response.data)
                })
        })
    },

    getRecordByID({ commit }, recordID) {
        return new Promise((resolve, reject) => {
            axios
                .get('/search/release/' + recordID, { withCredentials: true })
                .then(response => {
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error.response.data)
                })
        })
    },


};

const mutations = {
    setCurrentUser(state, user) {
        state.currentUser = user;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
