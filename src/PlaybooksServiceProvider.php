<?php

namespace Weble\LaravelPlaybooks;

use Illuminate\Support\ServiceProvider;
use Weble\LaravelPlaybooks\Command\MakePlaybookCommand;
use Weble\LaravelPlaybooks\Command\RunPlaybookCommand;

class PlaybooksServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('playbooks.php'),
        ], 'config');

        $this->app->bind('command.make:playbook', MakePlaybookCommand::class);
        $this->app->bind('command.playbook:run', RunPlaybookCommand::class);

        $this->commands([
            'command.make:playbook',
            'command.playbook:run'
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'playbooks');
    }
}
