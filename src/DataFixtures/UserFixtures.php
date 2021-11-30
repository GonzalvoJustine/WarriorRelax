<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Tag;
use App\Entity\User;
use App\Entity\Level;
use App\Entity\Option;
use App\Entity\Avatar;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $count = $_ENV["APP_FIXTURES_NB_USERS"] ?? 10;

        $levels = $manager->getRepository(Level::class)->findAll();
        $tags = $manager->getRepository(Tag::class)->findAll();
        $options = $manager->getRepository(Option::class)->findAll();

        $avatars = $manager->getRepository(Avatar::class)->findAll();

        shuffle($levels);
        shuffle($tags);
        shuffle($options);
        shuffle($avatars);

        $adminUser = new User();
        $adminUser
            ->setEmail('bubu@contact.fr')
            ->setPassword($this->passwordHasher->hashPassword(
                $adminUser,
                'bubu123456'
            ))
            ->setRoles(['ROLE_ADMIN'])
            ->setCreatedAt($faker->dateTime())
            ->setUsername('Bubu')
            ->setLastname($faker->lastName)
            ->setFirstname($faker->firstName)
            ->setGender($faker->titleMale)
            ->setBirthday($faker->dateTime())
            ->setLevel($levels[0])
            ->setTag($tags[0])
            ->setParameter($options[0])
            ->addAvatar($avatars[0])
        ;
        $manager->persist($adminUser);

        $testUser = new User();
        $testUser
            ->setEmail('baba@contact.fr')
            ->setPassword($this->passwordHasher->hashPassword(
                $adminUser,
                '123456'
            ))
            ->setRoles(['ROLE_USER'])
            ->setCreatedAt($faker->dateTime())
            ->setUsername('Baba')
            ->setLastname($faker->lastName)
            ->setFirstname($faker->firstName)
            ->setGender($faker->titleMale)
            ->setBirthday($faker->dateTime())
            ->setLevel($levels[0])
            ->setTag($tags[0])
            ->setParameter($options[0])
            ->addAvatar($avatars[0])
        ;
        $manager->persist($testUser);

        while($count > 0) {

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
            LevelFixtures::class,
        ];
    }

}
