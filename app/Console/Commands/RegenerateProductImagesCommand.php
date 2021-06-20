<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class RegenerateProductImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate product images.';

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

        $this->line('Regenerating product images');

        foreach ($products as $product) {
            $product->clearMediaCollection('vinyls');

            if ($product->vinyls->count() > 0 ) {
                $url = collect($product->vinyls->first()->images)
                    ->where('type', '=', 'primary')->first();

                if ($url) {
                    $product->addMediaFromUrl($url->resource_url)->toMediaCollection('vinyls', 'products');
                }

                $this->info('Product #' . $product->id . ' done!');
            }
        }

        return 0;
    }
}
