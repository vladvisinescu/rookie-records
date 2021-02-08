<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductDetails\Artist;
use App\Models\ProductDetails\Genre;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Artisan::call('permission:create-role super_admin');
        Artisan::call('permission:create-role user');

        $user = User::factory([
            'first_name' => 'Vlad',
            'last_name' => 'Visinescu',
            'email' => 'hello@rookie-records.co.uk',
            'password' => bcrypt('honterus'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ])->create();

        $user->assignRole('super_admin');

        Artist::factory()->count(50)->create();
        Genre::factory()->count(50)->create();

        User::factory()
//            ->has(
//                Product::factory()->count(20)
//            )
            ->count(100)
            ->create()->each->assignRole('user');
    }
}
