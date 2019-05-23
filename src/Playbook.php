<?php

namespace Weble\LaravelPlaybooks;

abstract class Playbook implements PlaybookInterface
{
    public static $timesRun = 0;

    public static function times(int $times): PlaybookDefinition
    {
        return PlaybookDefinition::times(static::class, $times);
    }

    public static function once(): PlaybookDefinition
    {
        return PlaybookDefinition::once(static::class);
    }

    public function before(): array
    {
        return [];
    }

    abstract public function run(): void;

    public function hasRun(): void
    {
        self::$timesRun += 1;
    }

    public function timesRun(): int
    {
        return self::$timesRun;
    }

    public function after(): array
    {
        return [];
    }
}
