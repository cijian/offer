<?php
namespace factoryAbstract;

class AnimalFactory extends Factory
{
    public function createFarm()
    {
        return new PigFarm();
    }

    public function createZoo()
    {
        return new PandaZoo();
    }
}
