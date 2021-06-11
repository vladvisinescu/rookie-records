<div class="js-cookie-consent cookie-consent w-screen fixed bottom-0 bg-gray-50 border-t-4 border-gray-200">
    <div class="container mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between">
            <span class="cookie-consent__message flex font-bold text-gray-700 items-center">{!! trans('cookieConsent::texts.message') !!}</span>

            <button class="js-cookie-consent-agree cookie-consent__agree inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                {{ trans('cookieConsent::texts.agree') }}
            </button>
        </div>
    </div>
</div>
