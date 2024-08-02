<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            CacheTableSeeder::class,
            CacheLocksTableSeeder::class,
            CounterTableSeeder::class,
            FailedJobsTableSeeder::class,
            JobsTableSeeder::class,
            MigrationsTableSeeder::class,
            NotificationsTableSeeder::class,
            PasswordResetTokensTableSeeder::class,
            SessionsTableSeeder::class,
            TabelLaporanTableSeeder::class,
            TabelRekeningTableSeeder::class,
            TabelTransaksiTableSeeder::class,
            TransaksiOtomatisTableSeeder::class,
            UsersTableSeeder::class,
        ]);
    }
}
