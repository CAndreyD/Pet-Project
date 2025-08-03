<?php

namespace Database\Factories;

use App\Models\Shipment;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentFactory extends Factory
{
    protected $model = Shipment::class;

    public function definition()
    {
        return [
            'supplier_id' => Supplier::factory(),
            'shipment_date' => $this->faker->date(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Shipment $shipment) {
            // Привяжем случайные продукты с количеством
            $products = \App\Models\Product::inRandomOrder()->take(rand(1, 5))->get();

            foreach ($products as $product) {
                $shipment->products()->attach($product->id, ['quantity' => rand(1, 100)]);
            }
        });
    }
}
