<?php

namespace App\Console\Commands;

use Artisan;
use DB;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class RefreshPermissionsTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the permissions table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Artisan::call('db:seed --class=PermissionSeeder');
        Artisan::call('permission:cache-reset');
        $this->info('Permissions table renewed.!');
        return CommandAlias::SUCCESS;
    }
}
