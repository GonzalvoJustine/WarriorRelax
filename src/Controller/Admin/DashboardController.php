<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Domain;
use App\Entity\Exercise;
use App\Entity\Level;
use App\Entity\Option;
use App\Entity\Program;
use App\Entity\Session;
use App\Entity\Tag;
use App\Entity\User;
use App\Repository\DomainRepository;
use App\Repository\ExerciseRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    protected $userRepository;
    protected $exerciseRepository;
    protected $domainRepository;

    public function __construct(
        UserRepository $userRepository,
        ExerciseRepository $exerciseRepository,
        DomainRepository $domainRepository,
    ) {
        $this->userRepository = $userRepository;
        $this->exerciseRepository = $exerciseRepository;
        $this->domainRepository = $domainRepository;
    }

    #[Route('/admin', name: 'app_admin')]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        return $this->render('bundles/EasyAdminBundle/welcome.html.twig', [
            'countAllUser' => $this->userRepository->countAllUser()
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Warrior Relax');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Tableau de bord', 'fa fa-home');

        yield MenuItem::section('Applications');
        yield MenuItem::linkToCrud('Programmes', 'fa fa-map-pin', Program::class);
        yield MenuItem::linkToCrud('Séances', 'fa fa-child', Session::class);
        yield MenuItem::linkToCrud('Exercises', 'fa fa-trophy', Exercise::class);

        yield MenuItem::section('Composants');
        yield MenuItem::linkToCrud('Domaines', 'fa fa-disease', Domain::class);
        yield MenuItem::linkToCrud('Catégories', 'fa fa-clipboard-list', Category::class);

        yield MenuItem::section('Authentification');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-users', User::class);

        yield MenuItem::section('Paramètre');
        yield MenuItem::linkToCrud('Options', 'fa fa-cogs', Option::class);
        yield MenuItem::linkToCrud('Niveaux', 'fa fa-cubes', Level::class);
        yield MenuItem::linkToCrud('Étiquettes', 'fa fa-tag', Tag::class);

    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->setName($user->getUsername())
            ->setAvatarUrl('https://i.pinimg.com/236x/cd/53/20/cd532068208c36be6fa310f1c615f30e.jpg')
            ->displayUserAvatar(true)
            ;
    }
}
