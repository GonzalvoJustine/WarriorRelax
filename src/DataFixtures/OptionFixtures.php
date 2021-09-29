<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Option;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class OptionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $count = $_ENV["APP_FIXTURES_NB_OPTIONS"] ?? 4;

        while($count > 0) {

            $option = new Option();
            $option ->setKeyOption($faker->text($maxNbChars = 5))
                    ->setValueOption($faker->text($maxNbChars = 5));

            $count--;
            $manager->persist($option);

        }

        $manager->flush();
    }

}
