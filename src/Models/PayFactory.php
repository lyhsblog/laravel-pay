<?php

namespace Ybzc\Laravel\Pay\Models;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Ybzc\Laravel\Pay\Models\Pay>
 */
class PayFactory extends Factory
{
    protected $model = Pay::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'amount' => $this->faker->randomDigitNotZero(),
            'no' => strtoupper($this->faker->bothify("??##-??##-??##-####"))
        ];
    }
}
