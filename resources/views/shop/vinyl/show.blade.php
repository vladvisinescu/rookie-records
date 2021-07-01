<x-shop-layout body-class="bg-gray-100">

    <x-slot name="title">Buy {{ $product->title }} by {{ implode(', ', $product->vinyls->first()->artists->pluck('name')->toArray()) }}</x-slot>

    <div class="mt-8 container mx-auto px-4 sm:px-6 lg:px-8">

        <vinyl-show :product='@json($product)'></vinyl-show>

        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-start items-center">
                <span class="bg-gray-100 mt-1 pr-3">
                    <svg class="inline-flex w-7 h-7" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" version="1.1" x="0px" y="0px" viewBox="0 0 100 125"><g transform="translate(0,-952.36218)"><path style="text-indent:0;text-transform:none;direction:ltr;block-progression:tb;baseline-shift:baseline;color:#000000;enable-background:accumulate;" d="m 49.96875,958.39343 c -24.259611,0 -44,19.74037 -44,43.99997 0,24.2596 19.740389,44 44,44 24.25961,0 44,-19.7404 44,-44 0,-24.2596 -19.74039,-43.99997 -44,-43.99997 z m 0,4.05962 c 22.099385,0 39.940383,17.84098 39.940383,39.94035 0,22.0994 -17.840998,39.9404 -39.940383,39.9404 -22.099386,0 -39.940383,-17.841 -39.940383,-39.9404 0,-22.09937 17.840997,-39.94035 39.940383,-39.94035 z m 0,3.96593 c -19.844469,0 -35.97445,16.12994 -35.97445,35.97442 a 1.9987804,1.9987804 0 1 0 3.997161,0 c 0,-17.68425 14.293044,-31.97726 31.977289,-31.97726 a 1.9987804,1.9987804 0 1 0 0,-3.99716 z m 0,7.99432 c -15.429328,0 -27.980128,12.55079 -27.980128,27.9801 a 1.9987804,1.9987804 0 1 0 3.997161,0 c 0,-13.26909 10.713865,-23.98294 23.982967,-23.98294 a 1.9987804,1.9987804 0 1 0 0,-3.99716 z m 0,7.99432 c -11.014186,0 -19.985806,8.97163 -19.985806,19.98578 a 1.9987803,1.9987803 0 1 0 3.997162,0 c 0,-8.85392 7.134691,-15.98861 15.988644,-15.98861 a 1.9987803,1.9987803 0 1 0 0,-3.99717 z m 0,7.99433 c -6.59904,0 -11.991483,5.39243 -11.991483,11.99145 0,6.599 5.392443,11.9915 11.991483,11.9915 6.599041,0 11.991483,-5.3925 11.991483,-11.9915 0,-6.59902 -5.392442,-11.99145 -11.991483,-11.99145 z m 0,3.99716 c 4.438815,0 7.994322,3.55549 7.994322,7.99429 0,4.4389 -3.555507,7.9944 -7.994322,7.9944 -4.438814,0 -7.994322,-3.5555 -7.994322,-7.9944 0,-4.4388 3.555508,-7.99429 7.994322,-7.99429 z m 17.76863,5.96449 a 1.9987803,1.9987803 0 0 0 -1.779986,2.0298 c 0,8.8539 -7.13469,15.9887 -15.988644,15.9887 a 1.9987803,1.9987803 0 1 0 0,3.9971 c 11.014187,0 19.985806,-8.9716 19.985806,-19.9858 a 1.9987803,1.9987803 0 0 0 -2.217176,-2.0298 z m 7.994322,0 a 1.9987804,1.9987804 0 0 0 -1.779985,2.0298 c 0,13.2691 -10.713866,23.983 -23.982967,23.983 a 1.9987804,1.9987804 0 1 0 0,3.9972 c 15.429327,0 27.980128,-12.5508 27.980128,-27.9802 a 1.9987804,1.9987804 0 0 0 -2.217176,-2.0298 z m 7.994323,0 a 1.9987804,1.9987804 0 0 0 -1.779986,2.0298 c 0,17.6843 -14.293044,31.9773 -31.977289,31.9773 a 1.9987804,1.9987804 0 1 0 0,3.9972 c 19.844469,0 35.97445,-16.13 35.97445,-35.9745 a 1.9987804,1.9987804 0 0 0 -2.217175,-2.0298 z" fill="#000000" fill-opacity="1" stroke="none" marker="none" visibility="visible" display="inline" overflow="visible"/></g></svg>
                </span>
                <span class="pr-3 bg-gray-100 font-bold text-lg font-medium text-gray-600">
                    You may also like
                </span>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($product->getRelated(6) as $key => $product)
                <div class="group bg-white overflow-hidden rounded-lg transition-shadow shadow hover:shadow-lg">
                    <a href="{{ route('shop.vinyl.show', ['slug' => $product->slug]) }}">
                        <div class="bg-red-500 relative" style="padding-bottom: 100%;">
                            <img src="{{ $product->vinyls->first()->discogs_image_url }}" class="absolute w-full h-full object-cover object-center" alt="">
                            <div class="absolute inset-0 bg-indigo-500 bg-opacity-50 transition-all transition-ease-in group-hover:bg-opacity-10" style="mix-blend-mode: darken"></div>
                            <div class="absolute inset-x-0 bottom-0 p-4">
                                <div class="flex flex-col object-none object-bottom text-shadow-md">
                                    <span class="font-bold text-white leading-tight">{{ $product->title }}</span>
                                    <div>
                                        <span class="inline-flex text-sm leading-tight text-white">
                                            {{ implode(', ', $product->vinyls->first()->artists->pluck('name')->all()) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="grid grid-cols-3 divide-x border-t border-b text-xs text-gray-500">
                        <div class="text-center py-3">
                            <span class="truncate">{{ $product->vinyls->first()->country }}</span>
                        </div>
                        <div class="text-center py-3">
                            <span>{{ $product->vinyls->first()->year ?: 'Not found' }}</span>
                        </div>
                        <div class="text-center py-3">
                            <span>{{ strtoupper($product->vinyls->first()->grading) }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-shop-layout>
