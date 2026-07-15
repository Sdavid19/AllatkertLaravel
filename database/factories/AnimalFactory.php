<?php

namespace Database\Factories;

use App\Helper\AnimalGenerator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Animal>
 */
class AnimalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
              
       $animalGenerator = new AnimalGenerator();
       $animal = $animalGenerator->GenerateAnimal();
        
        return [
            "name"=> fake()->firstName(),
            "species"=>$animal->name,
            "is_predator"=>$animal->isPredator,
            "born_at"=>fake()->dateTime(),
        ];
    }
}
