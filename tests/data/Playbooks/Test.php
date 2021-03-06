<?php

namespace App\Playbooks;

use Illuminate\Support\Facades\DB;
use Weble\LaravelPlaybooks\Playbook;

final class Test extends Playbook
{
    public function before(): array
    {
        return [

        ];
    }

    public function run(): void
    {
        $cars = [
            'Economy',
            'Business',
            'Family',
            'Sport',
            'Luxury',
            'Van',
            'Luxury Van',
        ];

        foreach ($cars as $car) {
            DB::table('cars')->insert([
                'title' => $car,
                'description' => $car,
            ]);
        }
    }

    public function after(): array
    {
        return [

        ];
    }
}
