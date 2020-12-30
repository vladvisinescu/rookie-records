const state = () => ({
    products: {

    }
});

const getters = {
    // currentUser: (state) => state.currentUser,
};

const actions = {
    /**
     * Get the currently logged-in user information
     * @param {*} Object Vuex
     */
    getCurrentUser({ commit }) {
        return new Promise((resolve, reject) => {

        });
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
