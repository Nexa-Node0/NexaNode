<?php
namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $count = (int) $this->command->ask(
            'How many Clients do you want to create?',
            5
        );

        if ($count > 0) {
            Client::factory($count)->create();

            $this->command->info("Created {$count} Clients");
            return;
        }

        $this->command->warn('Skipped: No Clients created');
    }
}
