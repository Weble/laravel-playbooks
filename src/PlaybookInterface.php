<?php

namespace Weble\LaravelPlaybooks;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface PlaybookInterface
{
    public static function times(int $times): PlaybookDefinition;

    public static function once(): PlaybookDefinition;

    public function before(): array;

    public function run(InputInterface $input, OutputInterface $output);

    public function hasRun(): void;

    public function timesRun(): int;

    public function after(): array;
}
