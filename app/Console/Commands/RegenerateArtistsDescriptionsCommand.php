<?php

namespace App\Console\Commands;

use App\Models\ProductDetails\Artist;
use Illuminate\Console\Command;
use Illuminated\Wikipedia\Wikipedia;

class RegenerateArtistsDescriptionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'artists:descriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate artists descriptions.';

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
        $artists = Artist::all();

        $this->line('Regenerating artists descriptions');

        foreach ($artists as $artist) {
            $search = (new Wikipedia)->preview($artist->name);

            if (!$search->isSuccess()) {
                continue;
            }

            $str = $search->getSections()->first()->getBody();

            if (!$str) {
                continue;
            }

            $artist->description = $str;
            $artist->save();

            $this->info('Artist ' . $artist->name . ' done!');
        }

        return 0;
    }
}
