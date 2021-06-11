<template>
    <div>
        <div class="mb-8">
            <h1 class="text-xl font-bold text-gray-700 border-b-4 border-gray-300 inline">Frequently Asked Questions</h1>
        </div>
        <div class="flex flex-col gap-y-4">
            <div v-for="faq in faqs" class="shadow-md border-gray-200 rounded-lg overflow-hidden">
                <div class="border-b-2 bg-gray-100 py-4 px-6">
                    <h1 class="font-bold text-gray-700"><span v-text="faq.number"></span>. <span v-text="faq.question"></span></h1>
                </div>
                <div class="py-4 px-6">
                    <p v-html="faq.answer"></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

    data() {
        return {
            faqs: [
                {
                    number: 1,
                    question: 'Where do you get the records from?',
                    answer: 'We mostly sell used vinyls in our shop. We have multiple sources where we buy our vinyls from: ebay, offline shopping from vinyl shops, vinyl fairs. We like traveling and discovering new record shops where we dig for records that might be of interest for our customers.'
                },
                {
                    number: 2,
                    question: 'What are my delivery options?',
                    answer: 'We are offering 2nd class standard UK delivery. For all our orders under £30 we charge a fix shipping fee of £5. All orders above £30 have free UK delivery.'
                },
                {
                    number: 3,
                    question: 'How long does it take to get my delivery?',
                    answer: 'We’re aiming at 1-2 days to dispatch your order and you should allow another 2-3 days for the post to deliver it. So in total there should be 5-7 days for your order to arrive.'
                },
                {
                    number: 4,
                    question: 'Can I ask for a refund?',
                    answer: 'We are currently not accepting any refunds. However, if you have changed your mind and want to cancel your order, please use our email address (contact@rookie-records.co.uk) to let us know about the cancellation and we’ll be happy to refund you.'
                },
                {
                    number: 5,
                    question: 'How much does the delivery cost?',
                    answer: 'For orders over £30, the delivery is free. For orders less than £30, we operate a fix delivery fee of £5.'
                },
                {
                    number: 6,
                    question: 'Do you ship outside the UK?',
                    answer: 'At the moment we do not deliver outside the UK.'
                },
                {
                    number: 7,
                    question: 'How can I pay? Can I use Paypal?',
                    answer: 'Currently we only support card payments, and we accept any card issuer (Visa, Mastercard, etc).'
                },
                {
                    number: 8,
                    question: 'How can I cancel/change my order?',
                    answer: 'If you’d like to cancel your order, you can drop us an email (contact@rookie-records.co.uk) and we’ll cancel your order. It may take up to 7 days to get the refund.'
                },
                {
                    number: 9,
                    question: 'I am experiencing issues with your website.',
                    answer: 'Use email: contact@rookierecords.co.uk to let us know what the issues are.'
                },
                {
                    number: 10,
                    question: 'What does each grading level (VG, G, P, F) mean?',
                    answer: 'TODO'
                }
            ]
        }
    }
}
</script>
