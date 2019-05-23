<?php

namespace Weble\LaravelPlaybooks;

use Illuminate\Support\ServiceProvider;
use Weble\LaravelPlaybooks\Command\MakePlaybookCommand;
use Weble\LaravelPlaybooks\Commands\RunPlaybookCommand;

class PlaybooksServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('playbooks.php'),
            ], 'config');

            $this->commands([
                MakePlaybookCommand::class,
                RunPlaybookCommand::class
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'playbooks');
    }
}
