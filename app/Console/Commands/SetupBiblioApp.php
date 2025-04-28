<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupBiblioApp extends Command
{
    protected $signature = 'biblio:setup';
    protected $description = 'Set up the Biblio App with migrations and seed data';

    public function handle()
    {
        $this->info('Setting up Biblio App...');
        
        $this->info('Migrating database...');
        Artisan::call('migrate:fresh');
        $this->info(Artisan::output());
        
        $this->info('Seeding database...');
        Artisan::call('db:seed');
        $this->info(Artisan::output());
        
        $this->info('Biblio App setup complete!');
        $this->info('Admin login: admin@example.com / password');
        $this->info('User login: user@example.com / password');
        
        return Command::SUCCESS;
    }
}
