<?php

namespace Webkul\MangoPay\Console\Commands;

use Illuminate\Console\Command;
use Webkul\MangoPay\Database\Seeders\DatabaseSeeder;
use Webkul\MangoPay\Providers\MangoPayServiceProvider;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mangopay:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs and configures the MangoPay package.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->components->info('Installing MangoPay package...');

        $this->call('migrate', [
            '--path' => realpath(__DIR__.'/../../Database/Migrations'),
            '--realpath' => true,
            '--force' => true,
        ]);

        $this->call('db:seed', [
            '--class' => DatabaseSeeder::class,
            '--force' => true,
        ]);

        $this->call('vendor:publish', [
            '--provider' => MangoPayServiceProvider::class,
            '--force' => true,
        ]);

        $this->call('optimize:clear');

        $this->output->writeln(file_get_contents(__DIR__.'/../../Templates/on-boarding.php'));

        $this->components->info('MangoPay package installed successfully!');

        return self::SUCCESS;
    }
}
