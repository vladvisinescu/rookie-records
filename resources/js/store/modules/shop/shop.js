const state = () => ({
    products: [],
    artists: [],
    genres: []
});

const getters = {
    allProducts: (state) => state.products,
    allArtists: (state) => state.artists,
    allGenres: (state) => state.genres,
};

const actions = {
    getProducts({ commit }, filters = {}) {
        return new Promise((resolve, reject) => {
            axios
                .get('/shop/vinyl/api', {
                    params: { ...filters }
                }, { withCredentials: true })
                .then(response => {
                    commit('setProducts', response.data)
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error.response.data)
                })
        })
    },

    getFilterData({ commit }) {
        return new Promise((resolve, reject) => {
            axios
                .get('/shop/vinyl/api/filter-data', {}, { withCredentials: true })
                .then(response => {
                    commit('setFilterData', response.data)
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error.response.data)
                })
        })
    }
};

const mutations = {
    setProducts(state, data) {
        state.products = data
    },

    setFilterData(state, data) {
        state.artists = data.artists
        state.genres = data.genres
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
