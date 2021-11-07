<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Domain;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class DomainFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $domains = ['Yoga', 'Renforcement', 'Étirement', 'Échauffement'];

        foreach($domains as $name){
            $domain = new Domain;
            $domain   ->setTitle($name)
                      ->setImage($faker->imageUrl());

            $manager->persist($domain);
        }

        $manager->flush();
    }
}