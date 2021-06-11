const state = () => ({
    products: {
        data: [],
        pagination: {}
    },
    artists: [],
    genres: [],
    years: [],
    countries: [],
    range: [1, 100],
    gradings: [
        { short: 'M', long: 'Mint', },
        { short: 'NM', long: 'Near Mint' },
        { short: 'VG+', long: 'Very Good+', },
        { short: 'VG', long: 'Very Good' },
        { short: 'G+', long: 'Good+' },
        { short: 'G', long: 'Good' },
        { short: 'F', long: 'Fair' },
        { short: 'P', long: 'Poor' }
    ]
});

const getters = {
    allProducts: (state) => state.products.data,
    pagination: (state) => state.products.pagination,
    allArtists: (state) => state.artists,
    allGenres: (state) => state.genres,
    allYears: (state) => state.years,
    allCountries: (state) => state.countries,
    allCategories: (state) => state.categories,
    priceRange: (state) => state.range,
    allGradings: (state) => state.gradings,
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
                    console.log(1, response.data)
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
        state.categories = data.categories
        state.range = data.range
        console.log(2, data.range)
        console.log(3, state.range)
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
