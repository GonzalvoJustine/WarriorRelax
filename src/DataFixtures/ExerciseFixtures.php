<?php

namespace App\DataFixtures;

use App\Entity\Domain;
use App\Repository\CategoryRepository;
use Faker;
use App\Entity\User;
use App\Entity\Level;
use App\Entity\Exercise;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ExerciseFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $count = $_ENV["APP_FIXTURES_NB_EXERCISES"] ?? 50;

        $levels = $manager->getRepository(Level::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();

        $categories = $manager->getRepository(Category::class)->findAll();
        $domains = $manager->getRepository(Domain::class)->findAll();

        while($count > 0) {

            shuffle($levels);
            shuffle($users);
            shuffle($categories);
            shuffle($domains);

            $exercise = new Exercise();
            $exercise   ->setTitle($faker->lastname)
                        ->setDescription($faker->text)
                        ->setIndication($faker->text)
                        ->setImage($faker->imageUrl())
                        ->setMedia($faker->imageUrl())
                        ->setCreatedAt($faker->dateTime())
                        ->setLevel($levels[0])
                        ->setUser($users[0])
                        ->addCategory($categories[0])
                        ->addDomain($domains[0])
            ;

            $count--;
            $manager->persist($exercise);

        }
        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies()
    {
        return [
            LevelFixtures::class,
            UserFixtures::class
        ];
    }
}
