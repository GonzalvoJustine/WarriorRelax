<?php

namespace App\DataFixtures;

use App\Entity\User;
use Faker;
use App\Entity\Tag;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TagFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $tag = new Tag();
        $tag    ->setKeyTag('VIP')
                ->setValueTag('Premium');

        $manager->persist($tag);

        $manager->flush();
    }
}
