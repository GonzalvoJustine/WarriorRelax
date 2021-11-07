<?php

namespace App\DataFixtures;

use App\Entity\Domain;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        //$categories = ['Dos', 'Bras', 'Jambes', 'Torse', 'Cuisse', 'Main', 'Nuque'];

        $count = $_ENV["APP_FIXTURES_NB_CATEGORIES"] ?? 7;

        $domains = $manager->getRepository(Domain::class)->findAll();

        while($count > 0) {

            shuffle($domains);

            $category = new Category;
            $category   ->setTitle($faker->name)
                        ->setImage($faker->imageUrl())
                        ->addDomain($domains[0])
            ;

            $count--;
            $manager->persist($category);
        }

       /* foreach($categories as $name){

            $test = new Category;
            $test   ->setTitle($name)
                        ->setImage($faker->imageUrl())
                        ->addDomain($this->getReference(DomainFixtures::DOMAIN_REFERENCE))
            ;

            $manager->persist($test);
        }*/

        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies()
    {
        return [
            DomainFixtures::class
        ];
    }
}
