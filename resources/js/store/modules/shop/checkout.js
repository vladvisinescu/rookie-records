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
                .post(route('shop.checkout.submit'), data, { withCredentials: true })
                .then(response => resolve(response.data))
                .catch(error => reject(error.response.data.errors))
        })
    },

    // submitPayment({ commit }, data) {
    //     return new Promise((resolve, reject) => {
    //         axios
    //             .post(route('shop.checkout.payment.submit', { order: data.order.transaction_id }), data, { withCredentials: true })
    //             .then(response => resolve(response.data))
    //             .catch(error => reject(error.response.data.errors))
    //     })
    // },

    confirmPayment({ commit }, { order, payment }) {
        return new Promise((resolve, reject) => {
            axios
                .patch(route('shop.checkout.payment.confirm', { order: order.transaction_id }), { order, payment }, { withCredentials: true })
                .then(response => resolve(response.data))
                .catch(error => reject(error.response.data.errors))
        })
    },

    getClientStripeSecret({ commit }) {
        return new Promise((resolve, reject) => {
            axios
                .post(route('shop.checkout.payment.secret'), {}, { withCredentials: true })
                .then(response => resolve(response.data))
                .catch(error => reject(error.response.data.errors))
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
