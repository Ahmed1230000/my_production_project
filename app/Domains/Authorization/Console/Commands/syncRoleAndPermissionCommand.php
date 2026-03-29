<?php

namespace App\Domains\Authorization\Console\Commands;

use App\Domains\User\Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Console\Command;

class syncRoleAndPermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $seeder = new RoleAndPermissionSeeder();
        $seeder->run();
        $this->info('Roles and permissions have been synchronized successfully.');
    }
}
