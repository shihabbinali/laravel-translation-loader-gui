<?php

namespace Elnooronline\LaravelTranslationLoaderGui\Commands;

use Elnooronline\LaravelTranslationLoaderGui\TranslationImporter;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Translation\FileLoader;
use Spatie\TranslationLoader\LanguageLine;

class TranslationImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translation:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load the language files into the database';

    /**
     * @var \Elnooronline\LaravelTranslationLoaderGui\TranslationImporter
     */
    private $importer;

    /**
     * Create a new command instance.
     *
     * @param \Elnooronline\LaravelTranslationLoaderGui\TranslationImporter $importer
     */
    public function __construct(TranslationImporter $importer)
    {
        parent::__construct();

        $this->importer = $importer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('Importing translations...');
        $files = $this->importer->import();

        foreach ($files as $file) {
            $this->info("$file");
        }

        $this->info("Done!\nYou can now use GUI to Manage your translation lines.");
    }
}
