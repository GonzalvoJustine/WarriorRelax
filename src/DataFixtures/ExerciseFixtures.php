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

        $exercises = [
            'Le danseur',
            'Le cobra',
            'Le triangle',
            'L’arbre',
            'Étirement cuisse',
            'La Fente haute debout',
            'Le Triangle Inversé',
            'Flexion arrière folle',
            'Le chien tête en bas',
            'Le triangle',
            'La guirlande',
            'Le bateau',
            'Posture des mains aux pieds',
            'Le corbeau',
            'Flexion avant en papillon',
            'La demi-pince tête au genou',
            'Le pont'
        ];

        $levels = $manager->getRepository(Level::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();

        $categories = $manager->getRepository(Category::class)->findAll();
        $domains = $manager->getRepository(Domain::class)->findAll();

        foreach($exercises as $name){

            shuffle($levels);
            shuffle($users);
            shuffle($categories);

            $exercise = new Exercise();
            $exercise   ->setTitle($name)
                        ->setCreatedAt($faker->dateTime())
                        ->setLevel($levels[0])
                        ->setUser($users[0])
                        ->addCategory($categories[0])
                        ->addDomain($domains[0])
            ;

            if($name === 'Le danseur') {
                $exercise   ->setDescription('Levez la jambe gauche vers l’arrière et attrapez le pied à l’aide de la main gauche et de la main droite. Puis pencher le haut du corps en avant. Bien garder les deux hances de face.')
                            ->setIndication('Niveau : Moyen. Durée : 1 fois 30s.')
                            ->setImage('https://images.unsplash.com/photo-1574406280735-351fc1a7c5e0?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1051&q=80')
                ;
            }
            if($name === 'Le cobra') {
                $exercise   ->setDescription('S’allonger sur le ventre jambes tendues, avec les mains de chaque coté de la poitrine en gardant le nombril près du sol et les coudes près du torse.')
                            ->setIndication('Inspirez en soulevant le torse et expirez en redescendant. Niveau : Débutant. Durée : 1 fois 30s.')
                            ->setImage('https://images.unsplash.com/photo-1621691211095-fe4b38f21788?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1334&q=80')
                ;
            }
            if($name === 'Le triangle') {
                $exercise   ->setDescription('Se positionner debout et bien droit, les jambes écartées à la largeur des épaules, s’incliner du coté de votre choix à 45° avec les bras tendus et perpendiculaire.')
                            ->setIndication('Reproduire le mouvement à chaque respirations. Niveau : Débutant. Durée : 1 fois 30s.')
                            ->setImage('https://images.unsplash.com/photo-1579125949392-01a09ee8511b?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1171&q=80')
                ;
            }
            if($name === 'L’arbre') {
                $exercise   ->setDescription('Se positionner debout sur la jambe droite, levez la jambe gauche en la glissant contre la jambe droite, genou vers l’extérieur. Levez les bras au ciel.')
                            ->setIndication('Niveau : Moyen. Durée : 1 fois 30s.')
                            ->setImage('https://images.unsplash.com/photo-1572492887328-4d2ecd6375cc?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1084&q=80')
                ;
            }
            if($name === 'Étirement cuisse') {
                $exercise   ->setDescription('En position debout, amener votre genou près de la poitrine en exerçant une traction avec les mains.')
                            ->setIndication('Niveau : Débutant. Durée : 30s pour chaque jambes.')
                            ->setImage('https://image.freepik.com/free-photo/young-female-workout-before-fitness-training-session-park_1150-37756.jpg')
                ;
            }
            if($name === 'La Fente haute debout') {
                $exercise   ->setDescription('Ouvrir l\'avant du corps avec le bassin, les épaules et la cage thoracique. Tendre les bras vers le haut les mains; jambe droite en avant et jambe gauche tendu vers à l\'arrière à genou.')
                            ->setIndication('Niveau : Débutant. Durée : 30s.')
                            ->setImage('https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1220&q=80')
                ;
            }
            if($name === 'Le Triangle Inversé') {
                $exercise   ->setDescription('Levez les bras parallèles au sol, les paumes vers le bas. Tournez votre pied gauche de 60 degrés vers la droite et votre pied droit de 90 degrés. Alignez le talon droit avec le talon gauche. Expirez, tournez le buste et le bassin vers la droite. Placez votre main gauche vers le bas, à l’intérieur ou à l’extérieur du pied droit. Levez le bras droit, gardez les genoux tendus. Etirez les épaules et les omoplates.')
                            ->setIndication('Niveau : Moyen. Durée : 30s.')
                            ->setImage('https://images.unsplash.com/photo-1547852356-68f969d6ac59?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80')
                ;
            }
            if($name === 'Flexion arrière folle') {
                $exercise   ->setDescription('Levez votre jambe droite vers le ciel, ouvrez la hanche et pliez le genou. Posez les orteils de votre pied droit au sol, genou droit fléchi, étirer le bras droit vers le haut et l’arrière, dans le même axe que votre corps. Avoir le pied gauche est bien ancré dans le sol jusqu’au petit orteil. Etirez-vous en poussant sur la jambe gauche, levez les hanches en laissant tomber votre tête en arrière. ')
                            ->setIndication('Niveau : Moyen. Durée : 15s.')
                            ->setImage('https://images.unsplash.com/photo-1599447332712-112c3d0cefb4?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1288&q=80')
                ;
            }
            if($name === 'Le chien tête en bas') {
                $exercise   ->setDescription('Poser les mains à terre en pliant les genoux; reculez les jambes et écarter les mains à la largeur des épaules. Soulever les talons, étirer les jambes et la colonne vertébrale. Descendre les talons vers le sol et étirer la face interne des bras dans les épaules; tourner le bord extérieur des bras vers l’intérieur puis rentrer les omoplates et ouvrir la poitrine. ')
                            ->setIndication('Niveau : Débutant. Durée : 30s.')
                            ->setImage('https://images.unsplash.com/photo-1547852355-26c780c450f9?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1171&q=80')
                ;
            }
            if($name === 'La guirlande') {
                $exercise   ->setDescription('Pieds joints, genoux qui touchent les coudes, tendre les bras devant et joindre les mains puis fléchir les genoux. Se mettre en position accroupie. ')
                            ->setIndication('Niveau : Débutant. Durée : 30s.')
                            ->setImage('https://images.unsplash.com/photo-1597361767826-3047f8305ad7?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1091&q=80')
                ;
            }
            if($name === 'Le bateau') {
                $exercise   ->setDescription('Joindre les mains vers devant la poitrine, garder les cuisses proches de la poitrine. Lever et tendre les jambes. ')
                            ->setIndication('Niveau : Débutant. Durée : 30s.')
                            ->setImage('https://images.unsplash.com/photo-1560232657-ffb2e8f5938a?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80')
                ;
            }
            if($name === 'Posture des mains aux pieds') {
                $exercise   ->setDescription('Descendre progressivement son buste, pieds écartés à la largeur des hanches. Mettre les mains sur la taille, étirer la colonne vertébrale. Se pencher vers l’avant en posant le ventre sur les cuisses. Crocheter les gros orteils entre vos majeurs et index. ')
                            ->setIndication('Niveau : Débutant. Durée : 30s.')
                            ->setImage('https://images.unsplash.com/photo-1592666879833-ec23f87d0207?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1168&q=80')
                ;
            }
            if($name === 'Le corbeau') {
                $exercise   ->setDescription('Placer les mains bien en dessous des épaules, joindre les pieds ensembles. Ouvrir les genoux à l’extérieur des bras, fléchir LES COUDES vers l’arrière. Lever les fessiers bien hauts et emboiter les genoux dans les aisselles, en gardant les coudes pliés. Basculer vers l’avant ,fixer un point loin devant.  Lever un pied très haut, puis l’autre et garder les pouces des orteils ensembles et monter les talons plus haut. ')
                            ->setIndication('Niveau : Avancé. Durée : 30s.')
                            ->setImage('https://images.unsplash.com/photo-1588783344727-f67e17b45dfc?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80')
                ;
            }
            if($name === 'Flexion avant en papillon') {
                $exercise   ->setDescription('S\'asseoir avec les pieds en contact, genoux ouvert de chaque cotés. Ancrer le fessier dans le sol tout en allongeant la colonne et le torse. Presse les talons l’un contre l’autre, saisir les plantes des pieds, avec les mains. Ouvrir les cuisses à l’horizontale. ')
                            ->setIndication('Niveau : Débutant. Durée : 30s.')
                            ->setImage('https://images.unsplash.com/photo-1531403939386-c08a16cd7eef?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1169&q=80')
                ;
            }
            if($name === 'La demi-pince tête au genou') {
                $exercise   ->setDescription('S\'asseoir sur le sol, jambes tendues en face de vous, inspirer et pliez votre genou droit, talon vers le périnée. Reposer le pied droit légèrement contre votre cuisse intérieure gauche. Tourner le torse vers la gauche. Aligner le nombril avec le milieu de la cuisse gauche, avec les mains prendre le pied gauche et les bras tendus, allongez le torse. Le ventre doit toucher les cuisses. ')
                            ->setIndication('Niveau : Débutant. Durée : 60s.')
                            ->setImage('https://images.unsplash.com/photo-1597586594276-456f8c50b82d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80')
                ;
            }
            if($name === 'Le pont') {
                $exercise   ->setDescription('S\'allonger sur le dos, bras le long du corps, paumes vers le sol. Plier les genoux et rapprochez les talons des fessiers. Étirez la nuque, amenez le menton vers la gorge, et écartez vos pieds de la largeur de vos hanches. Soulever le bas du dos. ')
                            ->setIndication('Niveau : Débutant. Durée : 30s.')
                            ->setImage('https://images.unsplash.com/photo-1599447332376-31836ce2aaaa?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1209&q=80')
                ;
            }

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
