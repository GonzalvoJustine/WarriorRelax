<?php

namespace App\DataFixtures;

use App\Entity\SessionHistory;
use Faker;
use App\Entity\Session;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SessionHistoryFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $count = $_ENV["APP_FIXTURES_NB_SESSIONS_HISTORY"] ?? 7;

        while($count > 0) {

            $sessionHistory = new SessionHistory();
            $sessionHistory ->setTitle($faker->lastname)
                            ->setCreatedAt($faker->dateTime());

            $count--;
            $manager->persist($sessionHistory);

        }

        $manager->flush();
    }
}
