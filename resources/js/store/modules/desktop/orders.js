const state = () => ({
    orders: {
        all: []
    },

    errors: [],
});

const getters = {
    getErrors: state => state.errors,
    getOrders: state => state.orders.all,
};

const actions = {
    getAllOrders({ commit }, filters = {}) {
        return new Promise((resolve, reject) => {
            axios
                .get(route('api.orders.all'))
                .then(response => {
                    commit('setOrdersList', response.data)
                    resolve(response.data)
                }).catch(error => {
                    reject(error.response.data.errors)
                })
        })
    },

    confirmOrder({ commit }, order) {
        return new Promise((resolve, reject) => {
            axios
                .patch(route('api.orders.confirm', { order }), { withCredentials: true })
                .then(response => {
                    // console.log(response)
                })
                .catch(error => {
                    reject(error.response.data.errors)
                })
        })
    },

    deleteOrder({ commit }, orderID) {
        return new Promise((resolve, reject) => {
            axios
                .delete('/api/orders/' + orderID, { withCredentials: true })
                .then(response => {
                    resolve(response.data)
                }).catch(error => {
                    commit('setErrors', error.response.data.errors)
                    reject(error.response.data.errors)
            })
        })
    },
};

const mutations = {
    setErrors(state, data) {
        state.errors = data
    },

    setOrdersList(state, data) {
        state.orders.all = data
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
