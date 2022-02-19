<?php

namespace App\Console\Commands;

use Artisan;
use Config;
use Illuminate\Console\Command;

class BackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup {--only-db} {--only-files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Take a backup with prefix name dependos on type (DB , files)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $params = $this->getArguments();
        Config::set('backup.backup.destination.filename_prefix', $params['name']);
        return Artisan::call('backup:run ' . $params['argument']);
    }

    /**
     * Get arguments to command dependos on options that send with command
     *
     * @return array
     */
    protected function getArguments()
    {
        if ($this->option('only-db')) {
            return ['name' => 'DB-', 'argument' => '--only-db'];
        }

        if ($this->option('only-files')) {
            return ['name' => 'Files-', 'argument' => '--only-files'];
        }
        return ['name' => '', 'argument' => ''];
    }
}
