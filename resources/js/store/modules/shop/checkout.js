import analytics from "../../../lib/analytics";

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
                .then(response => {
                    analytics.gPurchase(response.data.data)
                    resolve(response.data)
                })
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

};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
