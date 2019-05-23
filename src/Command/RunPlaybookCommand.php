<?php

namespace Weble\LaravelPlaybooks\Commands;

use Illuminate\Support\Str;
use Weble\LaravelPlaybooks\Playbook;
use Illuminate\Console\Command;
use Weble\LaravelPlaybooks\PlaybookDefinition;
use Symfony\Component\Console\Question\Question;

class RunPlaybookCommand extends Command
{
    protected $signature = 'playbook:run {playbook?} {--no-migration}';

    protected $description = 'Setup the database against a predefined playbook';

    protected $ranDefinitions = [];

    public function handle(): void
    {
        if (app()->environment() !== 'local') {
            $this->error('This command can only be run in the local environment!');
        }

        ini_set('memory_limit', '2048M');

        $playbookName = $this->argument('playbook');

        if (!$playbookName) {
            $availablePlaybooks = $this->getAvailablePlaybooks();

            $this->comment('Choose a playbook: '.PHP_EOL);

            foreach ($availablePlaybooks as $availablePlaybook) {
                $this->comment("- {$availablePlaybook}");
            }

            $this->comment('');

            $playbookName = $this->askPlaybookName($availablePlaybooks);
        }

        $playbookDefinition = $this->resolvePlaybookDefinition($playbookName);

        if (!$this->hasOption('--no-migration')) {
            $this->migrate();
        }

        $this->runPlaybook($playbookDefinition);
    }

    protected function migrate(): void
    {
        $this->info('Clearing the database');

        $this->call('migrate:refresh');
    }

    protected function runPlaybook(PlaybookDefinition $definition): void
    {
        foreach ($definition->playbook->before() as $before) {
            $this->runPlaybook(
                $this->resolvePlaybookDefinition($before)
            );
        }

        for ($i = 1; $i <= $definition->times; $i++) {
            if ($definition->once && $this->definitionHasRun($definition)) {
                break;
            }

            $this->infoRunning($definition->playbook, $i);

            $definition->playbook->run();
            $definition->playbook->hasRun();

            $this->ranDefinitions[$definition->id] = ($this->ranDefinitions[$definition->id] ?? 0) + 1;
        }

        foreach ($definition->playbook->after() as $after) {
            $this->runPlaybook(
                $this->resolvePlaybookDefinition($after)
            );
        }
    }

    protected function askPlaybookName(array $availablePlaybooks): string
    {
        $helper = $this->getHelper('question');

        $question = new Question('');

        $question->setAutocompleterValues($availablePlaybooks);

        $playbookName = (string) $helper->ask($this->input, $this->output, $question);

        if (!$playbookName) {
            $this->error('Please choose a playbook');

            return $this->askPlaybookName($availablePlaybooks);
        }

        return $playbookName;
    }

    protected function getAvailablePlaybooks(): array
    {
        $files = scandir(database_path('playbooks'));

        unset($files[0], $files[1]);

        return array_map(function (string $file) {
            return str_replace('.php', '', $file);
        }, $files);
    }

    protected function resolvePlaybookDefinition($class): PlaybookDefinition
    {
        if ($class instanceof PlaybookDefinition) {
            return $class;
        }

        if ($class instanceof Playbook) {
            return new PlaybookDefinition(get_class($class));
        }

        $className = $class;

        if (!Str::startsWith($class, ['\\Database\\Playbooks', 'Database\\Playbooks'])) {
            $className = "\\Database\\Playbooks\\{$class}";
        }

        return new PlaybookDefinition($className);
    }

    protected function infoRunning(Playbook $playbook, int $i): void
    {
        $playbookName = get_class($playbook);

        $this->info("Running playbook `{$playbookName}` (#{$i})");
    }

    protected function definitionHasRun(PlaybookDefinition $definition): bool
    {
        return isset($this->ranDefinitions[$definition->id]);
    }
}
