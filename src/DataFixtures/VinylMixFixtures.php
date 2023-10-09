<?php

namespace App\DataFixtures;

use App\Entity\VinylMix;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VinylMixFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $genres = ['pop', 'rock', 'heavy-metal'];

        for ($i = 1; $i <= 27; $i++) {
            $mix = new VinylMix();
            $mix
                ->setTitle("Mix {$i}")
                ->setDescription("Mix {$i} Description")
                ->setGenre($genres[array_rand($genres)])
                ->setTrackCount(rand(5, 20))
                ->setVotes(rand(-50, 50))
            ;
            $manager->persist($mix);
        }

        $manager->flush();
    }
}
