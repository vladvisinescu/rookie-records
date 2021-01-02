const state = () => ({
    genres: {
        all: []
    }
});

const getters = {
    allGenres: (state) => state.genres.all,
};

const actions = {

    getGenres({ commit }, filters = {}) {
        return new Promise((resolve, reject) => {
            axios
                .get('/genres', {
                    params: { ...filters }
                }, { withCredentials: true })
                .then(response => {
                    commit('setGenres', response.data)
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error.response.data)
                })
        })
    },

    createGenre({ commit, dispatch }, data) {
        return new Promise((resolve, reject) => {
            axios
                .post('/genres', {
                    ...data
                }, { withCredentials: true })
                .then(response => {
                    dispatch('getGenres')
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error.response.data)
                })
        })
    },
};

const mutations = {
    setGenres(state, data) {
        state.genres.all = data
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
