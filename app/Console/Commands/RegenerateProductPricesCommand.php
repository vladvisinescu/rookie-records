<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class RegenerateProductPricesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate product prices.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $products = Product::all();

        $this->line('Regenerating artists descriptions');

        foreach ($products as $product) {
            $this->line('Initial Price: ' . $product->price);
            $price = $product->price;
            $discogsPrice = $product->discogs_price;

            if ($discogsPrice !== 0.00) {
                $product->discogs_price = $price;

                $tempPrice = 0;
                if ($product->discogs_price <= 3) {
                    $tempPrice = $product->discogs_price * 2;
                } elseif (($product->discogs_price > 3) && ($product->discogs_price <= 10)) {
                    $tempPrice = $product->discogs_price * 1.5;
                } else {
                    $tempPrice = $product->discogs_price;
                }

                $product->price = $tempPrice;
                $product->save();
            }

            $this->line('Adjusted Price: ' . $product->price);
        }

        return 0;
    }
}
