<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Domain;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class DomainFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $domains = ['Yoga', 'Renforcement', 'Étirement', 'Échauffement'];

        foreach($domains as $name){
            $domain = new Domain;
            $domain ->setTitle($name);

            if($name === 'Yoga') {
                $domain ->setImage("https://images.unsplash.com/photo-1603988363607-e1e4a66962c6?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80");
            }
            if($name === 'Renforcement') {
                $domain ->setImage("https://images.unsplash.com/photo-1592334628151-36869c12ad0e?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1168&q=80");
            }
            if($name === 'Étirement') {
                $domain ->setImage("https://images.unsplash.com/photo-1600026453194-11ae289732b8?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1176&q=80");
            }
            if($name === 'Échauffement') {
                $domain ->setImage("https://images.unsplash.com/photo-1600679472025-f74038492f72?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80");
            }

            $manager->persist($domain);
        }

        $manager->flush();
    }
}