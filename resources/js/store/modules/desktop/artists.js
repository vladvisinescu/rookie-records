const state = () => ({
    artists: {
        all: []
    },
    new: {
        name: ''
    }
});

const getters = {
    allArtists: (state) => state.artists.all,
};

const actions = {

    getCurrentUser({ commit }) {
        return new Promise((resolve, reject) => {

        });
    },

    getArtists({ commit }, filters = {}) {
        return new Promise((resolve, reject) => {
            axios
                .get('/artists', {
                    params: { ...filters }
                }, { withCredentials: true })
                .then(response => {
                    commit('setArtists', response.data)
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error.response.data)
                })
        })
    },

    createArtist({ commit, dispatch }, data) {
        return new Promise((resolve, reject) => {
            axios
                .post('/artists', {
                    ...data
                }, { withCredentials: true })
                .then(response => {
                    dispatch('getArtists')
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
    },

    setArtists(state, data) {
        state.artists.all = data
    },

    setConfirmedRecord() {

    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
