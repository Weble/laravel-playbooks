<?php

namespace Weble\LaravelPlaybooks\Tests;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class RunPlaybookCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        File::copyDirectory(__DIR__. '/data', $this->app->basePath('app'));

        $this->loadMigrationsFrom(__DIR__ . '/database');
    }

    protected function tearDown(): void
    {
        File::deleteDirectories($this->app->basePath('app'));

        parent::tearDown();
    }

    /** @test */
    public function can_run_playbook()
    {
        $this->artisan('playbook:run Test')->assertExitCode(0);

        $this->assertDatabaseHas('cars', [
            'title' => 'Economy'
        ]);

    }

    /** @test */
    public function can_run_playbook_at_default_path_if_no_config_for_path_exists()
    {
        Config::set('playbooks.path', null);

        $this->artisan('playbook:run Test')->assertExitCode(0);

        $this->assertDatabaseHas('cars', [
            'title' => 'Economy'
        ]);
    }

    /** @test */
    public function can_run_playbook_at_a_custom_path_from_config()
    {
        Config::set('playbooks.path', 'Console/Playbooks');

        $this->artisan('playbook:run CustomPathTest')->assertExitCode(0);

        $this->assertDatabaseHas('cars', [
            'title' => 'Economy'
        ]);
    }

    /** @test */
    public function can_run_playbook_at_a_custom_path_from_malformed_config()
    {
        Config::set('playbooks.path', ' / Console/Playbooks/ ');

        $this->artisan('playbook:run CustomPathTest')->assertExitCode(0);

        $this->assertDatabaseHas('cars', [
            'title' => 'Economy'
        ]);
    }
}
