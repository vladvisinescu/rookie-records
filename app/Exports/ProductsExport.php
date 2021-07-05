<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromQuery, WithMapping, WithHeadings
{

    public $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function query()
    {
        return $this->products;
    }

    public function map($row): array
    {
        return [
            $row->getKey(),
            $row->title,
            'Media > Music & Sound Recordings',
            'Find this record and more on ' . config('app.name'),
            'in stock',
            'used',
            $row->price,
            route('shop.vinyl.show', $row->slug),
            $row->images['full'],
            $row->images['thumb'],
            'Rookie Records',
            1
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'title',
            'google_product_category',
            'description',
            'availability',
            'condition',
            'price',
            'link',
            'image_link',
            'additional_image_link',
            'brand',
            'quantity_to_sell'
        ];
    }
}
