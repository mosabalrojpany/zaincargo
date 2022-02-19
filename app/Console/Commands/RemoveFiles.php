<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;

class RemoveFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'my:removeFiles {--countries} {--customers} {--shippingInvoice}{--posts} {--editor}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all files for countries , customers , shipping invoices , posts and editor(CKeditor file manager)';

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
        $removeCountries = $this->option('countries');
        $removeCustomers = $this->option('customers');
        $removeShippingInvoice = $this->option('shippingInvoice');
        $removePosts = $this->option('posts');
        $removeEditor = $this->option('editor'); // files that user uplod them using file-manger (text editro 'CkEditor')

        $hasOptions = $removeCountries || $removeCustomers || $removeShippingInvoice || $removePosts || $removeEditor;

        if ($removeCountries || !$hasOptions) {
            $countriesFiles = File::allFiles(public_path('storage/images/countries'));
            if ($countriesFiles) {
                $this->info("\n" . 'Start delete Countries images');
                $this->DeleteFiles($countriesFiles);
            }
        }

        if ($removeCustomers || !$hasOptions) {
            $customersFiles = File::allFiles(public_path('storage/images/customers'));
            $customersFiles = array_merge($customersFiles, File::allFiles(storage_path('app/customers')));
            if ($customersFiles) {
                $this->info("\n" . 'Start delete Customers files');
                $this->DeleteFiles($customersFiles);
            }
        }

        if ($removeShippingInvoice || !$hasOptions) {

            $shippingInvoiceItems = File::allFiles(public_path('storage/images/shipping-invoices-items'));
            if ($shippingInvoiceItems) {
                $this->info("\n" . 'Start delete Shipping invoices items images');
                $this->DeleteFiles($shippingInvoiceItems);
            }
        }

        if ($removePosts || !$hasOptions) {
            $postsFiles = File::allFiles(storage_path('app/public/images/posts'));
            if ($postsFiles) {
                $this->info("\n" . 'Start delete posts files');
                $this->DeleteFiles($postsFiles);
            }
        }
        if ($removeEditor || !$hasOptions) {
            $editorFiles = File::allFiles(public_path('photos'));
            if ($editorFiles) {
                $this->info("\n" . 'Start delete editor files');
                $this->DeleteFiles($editorFiles, false);
            }
        }

        $this->line(""); // to add new line in console
        $this->alert('Done remove all files');
    }

    /**
     * Delete list of files.
     *
     * @return mixed
     */
    public function DeleteFiles(array $files)
    {
        $bar = $this->output->createProgressBar(count($files)); // count for progressBar
        $bar->start();

        foreach ($files as $file) {
            File::delete($file);
            $bar->advance();
        }

        $bar->finish(); // End progressBar
    }

}
