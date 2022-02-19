<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'my:resetApp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all cached files , remove files for complaints and suggestions , clear database with insert defaul values(call seeder)';

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
     * @return mixed
     */
    public function handle()
    {
        $this->call('optimize:clear');
        $this->call('key:generate');
        $this->call('my:removeFiles');
        $this->call('migrate:refresh',['--seed'=> 'defaul']);
    }
}
