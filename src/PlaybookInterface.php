<?php

namespace Weble\LaravelPlaybooks;

interface PlaybookInterface
{
    public static function times(int $times): PlaybookDefinition;

    public static function once(): PlaybookDefinition;

    public function before(): array;

    public function run(): void;

    public function hasRun(): void;

    public function timesRun(): int;

    public function after(): array;
}
