<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Level;
use App\Entity\Avatar;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AvatarFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $count = $_ENV["APP_FIXTURES_NB_AVATARS"] ?? 3;

        $levels = $manager->getRepository(Level::class)->findAll();

        while($count > 0) {

            shuffle($levels);

            $avatar = new Avatar();
            $avatar ->setImage($faker->imageUrl())
                    ->setLevel($levels[0]);

            $count--;
            $manager->persist($avatar);

        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            LevelFixtures::class
        ];
    }

}
