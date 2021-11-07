<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Domain;
use Faker;
use App\Entity\User;
use App\Entity\Level;
use App\Entity\Session;
use App\Entity\Exercise;
use App\Entity\SessionHistory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SessionFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $count = $_ENV["APP_FIXTURES_NB_SESSIONS"] ?? 10;

        $levels = $manager->getRepository(Level::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();
        $sessions_history = $manager->getRepository(SessionHistory::class)->findAll();

        $exercises = $manager->getRepository(Exercise::class)->findAll();

        $categories = $manager->getRepository(Category::class)->findAll();
        $domains = $manager->getRepository(Domain::class)->findAll();

        while($count > 0) {

            shuffle($levels);
            shuffle($users);
            shuffle($sessions_history);
            shuffle($exercises);
            shuffle($categories);
            shuffle($domains);

            $session = new Session();
            $session    ->setTitle($faker->lastname)
                        ->setImage($faker->imageUrl())
                        ->setCreatedAt($faker->dateTime())
                        ->setLevel($levels[0])
                        ->setUser($users[0])
                        ->setSessionHistory($sessions_history[0])
                        ->addExercise($exercises[0])
                        ->addCategory($categories[0])
                        ->addDomain($domains[0])
            ;

            $count--;
            $manager->persist($session);

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
            UserFixtures::class,
            ExerciseFixtures::class,
            SessionHistoryFixtures::class,
            DomainFixtures::class
        ];
    }
}
