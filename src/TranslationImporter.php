<?php

namespace Elnooronline\LaravelTranslationLoaderGui;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Translation\FileLoader;
use Spatie\TranslationLoader\LanguageLine;
use Illuminate\Support\Arr;

class TranslationImporter
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    private $app;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $files;

    /**
     * Create a new command instance.
     *
     * @param Application $app
     * @param \Illuminate\Filesystem\Filesystem $files
     */
    public function __construct(Application $app, Filesystem $files)
    {
        $this->app = $app;
        $this->files = $files;
    }

    /**
     * Load the translation files into the database.
     *
     * @return array
     */
    public function import()
    {
        $files = [];

        // Use the default file loader.
        $this->app->singleton('translation.loader', function ($app) {
            return new FileLoader($app['files'], $app['path.lang']);
        });

        // Loop over locale folders...
        foreach ($this->files->directories($this->app['path.lang']) as $languagePath) {
            // Get the locale name of the folder...
            $locale = basename($languagePath);

            // Loop over each group...
            foreach ($this->files->allfiles($languagePath) as $languageFile) {

                // get the filename of the group without extension...
                $group = pathinfo($languageFile)['filename'];

                $files[] = "$locale/$group.php";

                // Flatten a multi-dimensional associative array with dots.
                $translationLines = Arr::dot(trans($group, [], $locale));

                foreach ($translationLines as $lineKey => $lineValue) {

                    // Skip if the language line is an empty array...
                    if (empty($lineValue)) {
                        continue;
                    }

                    /** @var LanguageLine $line */
                    $line = LanguageLine::firstOrNew([
                        'key' => $lineKey,
                    ], [
                        'group' => $group,
                    ]);

                    if (! isset($line->text[$locale])) {
                        $line->setTranslation($locale, $lineValue)
                            ->save();
                    }
                }
            }
        }

        return $files;
    }
}
