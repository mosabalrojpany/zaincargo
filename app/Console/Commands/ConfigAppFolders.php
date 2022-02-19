<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;

class ConfigAppFolders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'my:configFolders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create application folders(Directories) if they do not exist';

    /**
     * The path of app folder in storage folder(Directory).
     *
     * @var string
     */
    protected $privatePath;

    /**
     * The path of public folder in storage folder(Directory).
     *
     * @var string
     */
    protected $publicPath;

    /**
     * The path of images in public folder in storage folder(Directory).
     *
     * @var string
     */
    protected $publicImagePath;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->privatePath = storage_path('app');
        $this->publicPath = $this->privatePath . '/public';
        $this->publicImagePath = $this->publicPath . '/images';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!file_exists(public_path('storage'))) {
            $this->call('storage:link');
        }
        $this->makeDirectory($this->publicImagePath . '/customers');
        $this->makeDirectory($this->publicImagePath . '/countries');
        $this->makeDirectory($this->publicImagePath . '/posts');
        $this->makeDirectory($this->publicImagePath . '/shipping-invoices-items');

        $this->makeDirectory($this->privatePath . '/customers/verifications', false);

        $this->makeDirectory($this->privatePath . '/money-transfers/files', false);
        $this->makeDirectory($this->privatePath . '/' . config('backup.backup.name'), false);
    }

    /**
     * Will create the given directory, including any needed sub-directories
     * @param string $directory  Directory with full path
     * @param boolean $makeAvatarFolder  Make sub-directory named avatar
     */
    protected function makeDirectory($directory, $makeAvatarFolder = true)
    {
        if ($makeAvatarFolder) {
            $directory .= '/avatar';
        }
        if (!file_exists($directory)) {
            File::makeDirectory($directory, '0775', true);
            $this->info("The [$directory] directory has been created.");
        }
    }

}
