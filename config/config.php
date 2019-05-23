<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Run only in these environments
    |--------------------------------------------------------------------------
    |
    | Do not allow Playbooks to be run in any environment outside of the ones specified here
    |
    | default: ['local']
     */
    'envs' => [
        'local'
    ],

    /*
    |--------------------------------------------------------------------------
    | Raise PHP memory limit
    |--------------------------------------------------------------------------
    |
    | Raise the default memory limit to avoid issues when running large playbooks.
    | Set to null to disable this feature.
    |
    | default: '20148M'
     */
    'raise_memory_limit' => '2048M',

    /*
    |--------------------------------------------------------------------------
    | Fresh Migration
    |--------------------------------------------------------------------------
    |
    | Run a migrate:refresh command before every playbook run by default.
    | This can be disabled or enabled manually through the
    | --no-migration or --migration options
    |
    | default: true
     */
    'migrate_by_default' => true
];