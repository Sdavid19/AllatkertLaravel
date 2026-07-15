<?php

namespace App\Helper;

class Animal
{
    public $name;
    public $species;
    public $isPredator;
    public $image;

    public function __construct($name, $species, $isPredator, $image)
    {
        $this->name = $name;
        $this->species = $species;
        $this->isPredator = $isPredator;
        $this->image = $image;
    }
}

class AnimalGenerator
{
    public $animals;

    public function __construct()
    {
        $this->animals = [
            new Animal('oroszlán', 'emlős', true, ''),
            new Animal('elefánt', 'emlős', false, ''),
            new Animal('pingvin', 'madár', false, ''),
            new Animal('kígyó', 'hüllő', true, ''),
            new Animal('gorilla', 'emlős', false, ''),
            new Animal('róka', 'emlős', true, ''),
            new Animal('medve', 'emlős', true, ''),
            new Animal('teknős', 'hüllő', false, ''),
            new Animal('farkas', 'emlős', true, ''),
            new Animal('páva', 'madár', false, ''),
            new Animal('hiéna', 'emlős', true, ''),
            new Animal('antilop', 'emlős', false, ''),
            new Animal('puma', 'emlős', true, ''),
            new Animal('zebra', 'emlős', false, '')
        ];
    }

    public function GenerateAnimal()
    {
        return $this->animals[array_rand($this->animals)];
    }
}
