<?php

namespace Database\Factories;

use App\Models\Code;
use App\Models\UserCode;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserCodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserCode::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code_id' => Code::factory(),
            'phone' => '0910123' . random_int(1000, 9999)
        ];
    }
}
