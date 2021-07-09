<?php

use Illuminate\Support\Facades\URL;

$url = URL::temporarySignedRoute('shop.index', now()->addMinutes(30));

?>

{{--{{ dd($url) }}--}}

<x-shop-layout body-class="bg-gray-100">
    <div class="mt-8 container mx-auto px-4 sm:px-6 lg:px-8">
        <checkout></checkout>
    </div>
</x-shop-layout>
