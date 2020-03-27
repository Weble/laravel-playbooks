<?php


namespace Weble\LaravelPlaybooks\Tests;


use Illuminate\Support\Facades\File;

class RunPlaybookCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/database');
    }

    /** @test */
    public function can_run_playbook()
    {
        $targetPath = $this->app->basePath('app');

        File::copy(__DIR__. '/data/Test.php', $targetPath . '/Playbooks/Test.php');

        $this->artisan('playbook:run Test')->assertExitCode(0);

        $this->assertDatabaseHas('cars', [
            'title' => 'Economy'
        ]);
    }
}
