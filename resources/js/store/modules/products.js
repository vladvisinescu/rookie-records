const state = () => ({
    products: {

    },

    new: {}
});

const getters = {
    // currentUser: (state) => state.currentUser,
};

const actions = {


};

const mutations = {
    setCurrentUser(state, user) {
        state.currentUser = user;
    },

    setConfirmedRecord(state, record) {
        state.new = record
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
