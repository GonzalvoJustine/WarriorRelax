<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Level;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class LevelFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $levels= ['débutant', 'intermédiaire', 'avancé'];
        // $nbLevels= [0,1,2,3,4,5,6,7,8,9,10];

        foreach($levels as $name){
            $level = new Level();
            $level  ->setName($name)
                    ->setLevel(rand(0,2));

            $manager->persist($level);
        }

        $manager->flush();
    }
}
