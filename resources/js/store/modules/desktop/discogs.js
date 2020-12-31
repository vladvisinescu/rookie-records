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
                .post('/search', { term }, { withCredentials: true })
                .then(response => {
                    console.log(response)
                })
        })
    }
};

const mutations = {
    setCurrentUser(state, user) {
        state.currentUser = user;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
