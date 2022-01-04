<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Unit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        'short_name' => $this->faker->company,
        'long_name' =>  $this->faker->company, //TODO сделать длинное имя на основе короткого
        'phone_main' =>$this->faker->phoneNumber,
        'phone_reserve' => $this->faker->phoneNumber,
        'email' => $this->faker->email,
        'unit_manager' => $this->faker->name,
        'unit_manager_phone' => $this->faker->phoneNumber,
        'unit_manager_email' => $this->faker->email,
        'unit_safety_manager' => $this->faker->name,
        'unit_safety_manager_phone' => $this->faker->phoneNumber,
        'unit_safety_manager_email' => $this->faker->email,
        'legal_address' => $this->faker->address,
        'post_address' => $this->faker->address,
        'parent_unit_id' => $this->faker->company, //TODO сделать связь с другими компаниями
        'status' => 'Активно',
        'logo_unit' => $this->faker->image('public/storage/images',640,480, null, false)
        ];
    }
}
