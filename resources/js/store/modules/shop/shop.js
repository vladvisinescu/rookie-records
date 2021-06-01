const state = () => ({
    products: {
        data: [],
        pagination: {}
    },
    artists: [],
    genres: [],
    years: [],
    countries: [],
});

const getters = {
    allProducts: (state) => state.products.data,
    pagination: (state) => state.products.pagination,
    allArtists: (state) => state.artists,
    allGenres: (state) => state.genres,
    allYears: (state) => state.years,
    allCountries: (state) => state.countries,
};

const actions = {
    getProducts({ commit }, filters = {}) {
        return new Promise((resolve, reject) => {
            axios
                .get('/shop/vinyl/api', {
                    params: { ...filters }
                }, { withCredentials: true })
                .then(response => {
                    resolve(response.data)
                    commit('setProducts', response.data)
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
    },
};

const mutations = {
    setProducts(state, data) {
        state.products.data = data.data
        delete data.data
        state.products.pagination = data
    },

    setFilterData(state, data) {
        state.artists = data.artists
        state.genres = data.genres
        state.years = data.years
        state.countries = data.countries
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
