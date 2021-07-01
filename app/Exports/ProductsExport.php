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
            'Find this record and more on <a href="' . url('/') . '">' . config('app.name') . '</a>',
            'in stock',
            $row->vinyls->first()->grading,
            $row->price . ' GBP',
            route('shop.vinyl.show', $row->slug),
            $row->images['full'],
            'Rookie Records',
            1
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'title',
            'description',
            'availability',
            'condition',
            'price',
            'link',
            'image_link',
            'brand',
            'quantity_to_sell'
        ];
    }
}
