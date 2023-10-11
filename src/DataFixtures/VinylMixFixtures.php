<?php

namespace App\DataFixtures;

use App\Factory\VinylMixFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VinylMixFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       VinylMixFactory::createMany(27);
    }
}
