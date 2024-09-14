<?php

namespace Elnooronline\LaravelTranslationLoaderGui\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Elnooronline\LaravelTranslationLoaderGui\Controller;
use Elnooronline\LaravelTranslationLoaderGui\Commands\TranslationImportCommand;

class TranslationLoaderGuiProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param \Illuminate\Routing\Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                TranslationImportCommand::class,
            ]);

            $this->publishes([
                $this->packagePath('config/translation-loader-gui.php') => config_path('translation-loader-gui.php'),
            ], 'translation-loader-gui-config');

            $this->publishes([
                $this->packagePath('resources/views') => base_path('resources/views/vendor/translation-loader-gui'),
            ], 'translation-loader-gui-views');
        }

        $this->loadViewsFrom($this->packagePath('resources/views'), 'translation-loader-gui');

        $this->mergeConfigFrom(
            $this->packagePath('config/translation-loader-gui.php'),
            'translation-loader-gui'
        );

        if ($this->app['config']->get('translation-loader-gui.enabled')) {
            $config = $this->app['config']->get('translation-loader-gui.route', []);
            $router->group($config, function ($router) {
                $router->post('translation-loader', Controller::class . '@load')
                    ->name('_translation-loader.load')->middleware(['auth', 'verified']);

                $router->get('translation-loader', Controller::class . '@index')
                    ->name('_translation-loader.index')->middleware(['auth', 'verified']);

                $router->put('translation-loader/{languageLine}', Controller::class . '@update')
                    ->name('_translation-loader.update')->middleware(['auth', 'verified']);
            });
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Generate a path relative to the package root directory.
     *
     * @param $path
     * @return string
     */
    private function packagePath($path)
    {
        return __DIR__ . "/../../$path";
    }
}
