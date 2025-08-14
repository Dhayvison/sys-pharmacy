<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::transaction(function () {
            Role::create(['name' => 'admin']);
            Role::create(['name' => 'employee']);
            Role::create(['name' => 'client']);

            $user = User::factory()->create([
                'email' => env('APP_ADMIN_EMAIL'),
                'password' => bcrypt(env('APP_ADMIN_PASSWORD')),
                'name' => env('APP_ADMIN_NAME'),
            ]);

            $user->assignRole('admin');
        });
    }
}
