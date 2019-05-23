<?php

namespace Weble\LaravelPlaybooks;

use Illuminate\Support\Facades\Facade;

class PlaybooksFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Playbooks';
    }
}
