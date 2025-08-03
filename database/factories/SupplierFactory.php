<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company(), // Название компании, норм для поставщика
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
