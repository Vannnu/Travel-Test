<?php declare(strict_types=1);

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

/**
 * Class DatabaseSeeder.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Const use to check if the command can be run in the env.
     */
    public const ENV_ENABLED = 'local';

    /**
     * Models class to seed.
     *
     * @var array|string[]
     */
    private array $strategy = [
        PaymentMethodSeeder::class,
        TravelSeeder::class,
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->refreshDatabase();

        // Seed each model and display information about the process
        foreach ($this->strategy as $modelSeeder) {
            try {
                $this->command->info("Seeding model: {$modelSeeder}...");
                (new $modelSeeder())->seed();
                $this->command->info("Seeding for {$modelSeeder} completed successfully.");
            } catch (Exception $e) {
                Log::error("Seeding failed for {$modelSeeder}: " . $e->getMessage());
                $this->command->error("Seeding for {$modelSeeder} failed: " . $e->getMessage());
            }
        }
    }

    /**
     * Refresh the database if in local environment.
     *
     * @return void
     */
    private function refreshDatabase(): void
    {
        if (env('APP_ENV') === self::ENV_ENABLED) {
            try {
                $this->command->info('Refreshing database...');

                Artisan::call('migrate:rollback');
                Artisan::call('migrate');

                $this->command->info('Database has been refreshed in local environment.');
            } catch (Exception $e) {
                Log::error('Database refresh failed: ' . $e->getMessage());
                $this->command->error('Database refresh failed: ' . $e->getMessage());
            }
        } else {
            $this->command->info('Database refresh skipped in non-local environment.');
        }
    }
}
