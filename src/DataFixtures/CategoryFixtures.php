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

        $categories = ['Dos', 'Bras', 'Jambes', 'Cuisses', 'Main', 'Cou', 'Haut du corps', 'Bas du corps', 'Abdos'];

        $domains = $manager->getRepository(Domain::class)->findAll();

        foreach($categories as $name){

            shuffle($domains);

            $category = new Category;
            $category   ->setTitle($name)
                        ->addDomain($domains[0])
            ;

            if($name === 'Abdos') {
                $category ->setImage("https://image.freepik.com/photos-gratuite/femme-sport-formation-dans-matin-gymnase_1157-28771.jpg");
            }
            if($name === 'Main') {
                $category ->setImage("https://image.freepik.com/photos-gratuite/photo-belle-femme-elegante-peau-saine-propre_186202-8364.jpg");
            }
            if($name === 'Bras') {
                $category ->setImage("https://images.unsplash.com/photo-1534367507873-d2d7e24c797f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80");
            }
            if($name === 'Cou') {
                $category ->setImage("https://images.unsplash.com/photo-1626893596460-eb3bb2f7bc9c?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1331&q=80");
            }
            if($name === 'Dos') {
                $category ->setImage("https://images.unsplash.com/photo-1599901860904-17e6ed7083a0?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80");
            }
            if($name === 'Cuisses') {
                $category ->setImage("https://images.unsplash.com/photo-1574406280735-351fc1a7c5e0?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1051&q=80");
            }
            if($name === 'Haut du corps') {
                $category ->setImage("https://images.unsplash.com/photo-1621691211095-fe4b38f21788?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1934&q=80");
            }
            if($name === 'Jambes') {
                $category ->setImage("https://images.unsplash.com/photo-1609351043101-4f9e5b817456?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80");
            }
            if($name === 'Bas du corps') {
                $category ->setImage("https://images.unsplash.com/photo-1566241134883-13eb2393a3cc?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80");
            }

            $manager->persist($category);

        }

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
