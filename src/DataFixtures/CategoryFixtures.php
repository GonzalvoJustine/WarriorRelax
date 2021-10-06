<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $categoriesParents = ['Yoga', 'Renforcement', 'Étirement', 'Échauffement'];
        $categoriesChildren = ['Dos', 'Bras', 'Jambes', 'Torse', 'Cuisse', 'Main', 'Nuque'];

        foreach($categoriesParents as $parent){
            $category = new Category;
            $category   ->setTitle($parent)
                        ->setImage($faker->imageUrl());

            $manager->persist($category);
        }

        foreach($categoriesChildren as $child){
            $category = new Category;
            $category   ->setTitle($child)
                        ->setImage($faker->imageUrl())
                        ->setTerm('child');

            $manager->persist($category);
        }

        $manager->flush();
    }
}
