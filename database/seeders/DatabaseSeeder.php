<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Enclosure;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(8)->create();

        $users->first()->update([
            'admin' => true
        ]);

        $enclosures = Enclosure::factory(8)->create();

        for ($i = 0; $i < 15; $i++) {
            $animal = Animal::factory()->make();

            $enclosureFound = false;

            foreach ($enclosures->shuffle() as $enclosure) {
                $existingAnimals = Animal::where('enclosure_id', $enclosure->id)->get();

                if ($existingAnimals->count() >= $enclosure->limit) {
                    continue;
                }

                $hasPredator = $existingAnimals->contains('is_predator', true);
                $hasHerbivore = $existingAnimals->contains('is_predator', false);

                $canPlace = !($hasPredator && !$animal->is_predator) && !($hasHerbivore && $animal->is_predator);

                if ($canPlace) {
                    $animal->enclosure_id = $enclosure->id;
                    $animal->save();
                    $enclosureFound = true;
                    break;
                }
            }

            if (!$enclosureFound) {
                continue;
            }
        }

        foreach ($enclosures as $enclosure) {
            $randomUsers = $users->random(rand(1, 3))->pluck('id');
            $enclosure->users()->sync($randomUsers);
        }
    }
}
