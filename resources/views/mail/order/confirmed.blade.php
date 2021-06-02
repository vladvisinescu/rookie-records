@component('mail::message')
# Thank you for your order!

Here are the lovely records you'll soon listen to:



@component('mail::table')
| Product       | Quantity      | Price    |
| ------------- |:-------------:| --------:|
@foreach($order->products as $product)
| {{ $product->title }} | 1 | {{ $product->price }} |
@endforeach
@endcomponent

@component('mail::button', ['url' => route('user.account.orders')])
See all your orders
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
