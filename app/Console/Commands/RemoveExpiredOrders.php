<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class RemoveExpiredOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleans up expired orders';

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
        $orders = Order::query();
        $orders = $orders->whereNull('payed_at')->get();

//        dd($orders);

        $orders->map(function ($order) {
            $this->line('Cleaning order #' . $order->getKey());
            $order->products()->restore();
            $order->products()->detach();
            $order->delete();
        });

        return 0;
    }
}
