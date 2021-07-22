export default {
    gAddToCart(product) {
        window.dataLayer.push({
            event: 'add_to_cart',
            currency: 'GBP',
            value: product.price,
            items: [
                {
                    item_id: product.uuid,
                    item_name: product.title,
                    currency: 'GBP',
                    item_category: "Music",
                    item_category2: "Vinyl",
                    price: product.price,
                    quantity: 1
                }
            ]
        })
    },

    gRemoveFromCart(product) {
        window.dataLayer.push({
            event: 'remove_from_cart',
            currency: 'GBP',
            value: product.price,
            items: [
                {
                    item_id: product.uuid,
                    item_name: product.title,
                    currency: 'GBP',
                    item_category: "Music",
                    item_category2: "Vinyl",
                    price: product.price,
                    quantity: 1
                }
            ]
        })
    },

    gPurchase(cart) {
        window.dataLayer.push({
            event: "purchase",
            currency: "GBP",
            transaction_id: cart.transaction_id,
            value: cart.total,
            items: cart.products.map(item => {
                return {
                    item_id: item.uuid,
                    item_name: item.title,
                    currency: "GBP",
                    item_category: "Music",
                    item_category2: "Vinyl",
                    price: item.price,
                    quantity: 1
                }
            }),
        });
    }
}
