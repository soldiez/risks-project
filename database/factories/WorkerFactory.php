<?php

namespace Database\Factories;

use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Worker::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //

            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'middle_name'=> $this->faker->firstName,
            'phone'=> $this->faker->phoneNumber,
            'email' => $this->faker->unique->email,
            'personnel_number' => $this->faker->numberBetween([9900, 10000]),
            'job_position' => $this->faker->jobTitle,
            'department' => $this->faker->company,
            'unit_id' => $this->faker->company,
            'birthday' => $this->faker->date('Y-m-d'),
            'status' => 'Активен'
            ];
    }
}
