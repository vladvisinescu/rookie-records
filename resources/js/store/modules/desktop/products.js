const state = () => ({
    products: {
        data: []
    }
});

const getters = {
    // currentUser: (state) => state.currentUser,
};

const actions = {
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
