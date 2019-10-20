<?php
namespace factoryAbstract;

class PlantFactory extends Factory
{
    public function createFarm()
    {
        return new RiceFarm();
    }

    public function createZoo()
    {
        return new PeonyZoo();
    }
}
