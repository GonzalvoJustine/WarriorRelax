<?php

namespace App\DataFixtures;

use App\Entity\Avatar;
use App\Entity\Option;
use Faker;
use App\Entity\Tag;
use App\Entity\User;
use App\Entity\Level;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $count = $_ENV["APP_FIXTURES_NB_USERS"] ?? 10;

        $levels = $manager->getRepository(Level::class)->findAll();
        $tags = $manager->getRepository(Tag::class)->findAll();
        $options = $manager->getRepository(Option::class)->findAll();

        $avatars = $manager->getRepository(Avatar::class)->findAll();

        while($count > 0) {

            shuffle($levels);
            shuffle($tags);
            shuffle($options);
            shuffle($avatars);

            $user = new User();
            $user   ->setEmail($faker->email)
                    ->setPassword($faker->password)
                    ->setRoles([])
                    ->setCreatedAt($faker->dateTime())
                    ->setUsername($faker->firstName)
                    ->setLastname($faker->lastName)
                    ->setFirstname($faker->firstName)
                    ->setGender($faker->titleMale)
                    ->setBirthday($faker->dateTime())
                    ->setLevel($levels[0])
                    ->setTag($tags[0])
                    ->setParameter($options[0])
                    ->addAvatar($avatars[0]);

            $count--;
            $manager->persist($user);

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
