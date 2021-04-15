const state = () => ({
    orders: [],
});

const getters = {
    getOrders: (state) => state.orders,
};

const actions = {
    getOrders({ commit }) {
        return new Promise((resolve, reject) => {
            axios.get(route('api.user.orders')).then(response => {
                commit('setOrders', response.data.data)
                resolve(response.data.data)
            }).catch(error => {
                reject(error.response.data)
            })
        })
    }
};

const mutations = {
    setOrders(state, orders) {
        state.orders = orders;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
