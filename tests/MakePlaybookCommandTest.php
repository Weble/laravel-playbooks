<?php

namespace Weble\LaravelPlaybooks\Tests;

use Illuminate\Support\Facades\File;

class MakePlaybookCommandTest extends TestCase
{
    /** @test */
    public function can_create_a_playbook()
    {
        $targetStubsPath = $this->app->basePath('app');

        $this->artisan('make:playbook Test')->assertExitCode(0);

        $publishedStubPath = $targetStubsPath . '/Playbooks/Test.php';
        $this->assertFileExists($publishedStubPath);
    }

    /** @test */
    public function can_create_a_playbook_in_a_custom_namespace()
    {
        $targetStubsPath = $this->app->basePath('app');

        $this->artisan('make:playbook Console/Playbooks/Test')->assertExitCode(0);

        $publishedStubPath = $targetStubsPath . '/Console/Playbooks/Test.php';
        $this->assertFileExists($publishedStubPath);
    }
}
