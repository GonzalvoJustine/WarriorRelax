<?php

namespace App\DataFixtures;

use App\Entity\Domain;
use Faker;
use App\Entity\User;
use App\Entity\Level;
use App\Entity\Session;
use App\Entity\Program;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $count = $_ENV["APP_FIXTURES_NB_PROGRAMS"] ?? 1;

        $levels = $manager->getRepository(Level::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();
        $sessions = $manager->getRepository(Session::class)->findAll();

        $categories = $manager->getRepository(Category::class)->findAll();

        while($count > 0) {

            shuffle($levels);
            shuffle($users);
            shuffle($sessions);
            shuffle($categories);

            $program = new Program();
            $program    ->setTitle($faker->lastname)
                        ->setDate($faker->dateTime())
                        ->setRepeatProgram(0)
                        ->setCreatedAt($faker->dateTime())
                        ->setLevel($levels[0])
                        ->setUser($users[0])
                        ->setSession($sessions[0])
                        ->addCategory($categories[0])
            ;

            $count--;
            $manager->persist($program);

        }

        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            SessionFixtures::class,
            CategoryFixtures::class
        ];
    }
}
