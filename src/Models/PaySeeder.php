<?php

namespace Ybzc\Laravel\Pay\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class PaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Pay::factory()
            ->count(50)
            ->create();
    }
}
