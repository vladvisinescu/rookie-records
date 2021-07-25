const Ziggy = {"url":"http:\/\/local.rookie-records.co.uk","port":null,"defaults":{},"routes":{"cashier.payment":{"uri":"stripe\/payment\/{id}","methods":["GET","HEAD"]},"cashier.webhook":{"uri":"stripe\/webhook","methods":["POST"]},"api.orders.all":{"uri":"api\/orders","methods":["GET","HEAD"]},"api.orders.confirm":{"uri":"api\/orders\/{order}\/confirm","methods":["PATCH"],"bindings":{"order":"id"}},"api.orders.delete":{"uri":"api\/orders\/{order}","methods":["DELETE"]},"api.categories":{"uri":"api\/categories","methods":["GET","HEAD"]},"api.addresses.lookup":{"uri":"api\/addresses\/postcode\/{postcode}","methods":["GET","HEAD"]},"api.addresses.update":{"uri":"api\/addresses\/{address}","methods":["PATCH"],"bindings":{"address":"id"}},"api.addresses.delete":{"uri":"api\/addresses\/{address}","methods":["DELETE"],"bindings":{"address":"id"}},"api.user.get":{"uri":"api\/user","methods":["GET","HEAD"]},"api.user.update":{"uri":"api\/user","methods":["PATCH"]},"api.user.orders":{"uri":"api\/user\/orders","methods":["GET","HEAD"]},"home":{"uri":"\/","methods":["GET","HEAD"]},"home.faq":{"uri":"faq","methods":["GET","HEAD"]},"home.terms":{"uri":"terms-and-conditions","methods":["GET","HEAD"]},"home.policy":{"uri":"privacy-policy","methods":["GET","HEAD"]},"home.cookie":{"uri":"cookie-policy","methods":["GET","HEAD"]},"home.delivery":{"uri":"delivery-policy","methods":["GET","HEAD"]},"home.contact-us":{"uri":"contact-us","methods":["GET","HEAD"]},"home.contact-us.submit":{"uri":"contact-us","methods":["POST"]},"shop.search":{"uri":"search","methods":["GET","HEAD"]},"auth.social.redirect":{"uri":"auth\/{provider}\/redirect","methods":["GET","HEAD"]},"auth.social.callback":{"uri":"auth\/{provider}\/callback","methods":["GET","HEAD"]},"auth.social.delete":{"uri":"auth\/{provider}\/delete","methods":["GET","HEAD"]},"shop.checkout.index":{"uri":"shop\/checkout","methods":["GET","HEAD"]},"shop.checkout.submit":{"uri":"shop\/checkout\/submit","methods":["POST"]},"shop.checkout.payment.secret":{"uri":"shop\/checkout\/order\/secret","methods":["POST"]},"shop.checkout.order.details":{"uri":"shop\/checkout\/order\/{orderID}","methods":["GET","HEAD"]},"shop.cart.get":{"uri":"shop\/cart","methods":["GET","HEAD"]},"shop.cart.add":{"uri":"shop\/cart\/{id}","methods":["DELETE"]},"shop.vinyl":{"uri":"shop\/vinyl\/api","methods":["GET","HEAD"]},"shop.vinyl.filter-data":{"uri":"shop\/vinyl\/api\/filter-data","methods":["GET","HEAD"]},"shop.index":{"uri":"shop\/vinyl","methods":["GET","HEAD"]},"shop.vinyl.show":{"uri":"shop\/vinyl\/{slug}","methods":["GET","HEAD"]},"user.account.home":{"uri":"account\/details","methods":["GET","HEAD"]},"user.account.orders":{"uri":"account\/orders","methods":["GET","HEAD"]},"desktop.home":{"uri":"desktop","methods":["GET","HEAD"]},"desktop.products.home":{"uri":"desktop\/products","methods":["GET","HEAD"]},"desktop.products.create":{"uri":"desktop\/products\/create","methods":["GET","HEAD"]},"desktop.orders.home":{"uri":"desktop\/orders","methods":["GET","HEAD"]},"dashboard":{"uri":"dashboard","methods":["GET","HEAD"]},"register":{"uri":"register","methods":["GET","HEAD"]},"login":{"uri":"login","methods":["GET","HEAD"]},"password.request":{"uri":"forgot-password","methods":["GET","HEAD"]},"password.email":{"uri":"forgot-password","methods":["POST"]},"password.reset":{"uri":"reset-password\/{token}","methods":["GET","HEAD"]},"password.update":{"uri":"reset-password","methods":["POST"]},"verification.notice":{"uri":"verify-email","methods":["GET","HEAD"]},"verification.verify":{"uri":"verify-email\/{id}\/{hash}","methods":["GET","HEAD"]},"verification.send":{"uri":"email\/verification-notification","methods":["POST"]},"password.confirm":{"uri":"confirm-password","methods":["GET","HEAD"]},"logout":{"uri":"logout","methods":["POST"]}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };
