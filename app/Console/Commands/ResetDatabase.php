<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tm:reset-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop all tables, re-migrate, and re-seed the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('migrate:fresh');
        $this->call('db:seed');

        $this->info('Database has been refreshed and re-seeded.');
    }
}
