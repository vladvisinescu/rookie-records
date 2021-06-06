const state = () => ({
    products: [],
});

const getters = {
    //
};

const actions = {
    submitOrder({ commit }, data) {
        return new Promise((resolve, reject) => {
            axios
                .post('/shop/checkout/submit', data, {
                    withCredentials: true
                })
                .then(response => {
                    // console.log(response.data)
                    commit('', response.data)
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error.response.data.errors)
                })
        })
    },
};

const mutations = {
    //
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
