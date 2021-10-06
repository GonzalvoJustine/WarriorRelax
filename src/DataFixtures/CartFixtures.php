<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Cart;
use App\Entity\Exercise;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CartFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $exercises = $manager->getRepository(Exercise::class)->findAll();

        shuffle($exercises);

        $cart = new Cart();
        $cart   ->setTitle($faker->lastname)
                ->setTotalExercise(rand(0, 10))
                ->setExercises($exercises[0])
        ;

        $manager->persist($cart);

        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ExerciseFixtures::class
        ];
    }
}
