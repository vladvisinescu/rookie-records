const state = () => ({
    user: {},
});

const getters = {
    getUser: (state) => state.user,
};

const actions = {

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
