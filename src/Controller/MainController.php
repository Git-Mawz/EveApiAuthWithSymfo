<?php

namespace App\Controller;

use App\Services\AuthChecker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_home")
     */
    public function home(AuthChecker $authChecker)
    {   if ($authChecker->isAuthenticated()) {
            $this->redirectToRoute('capsuler_home');
        }
        return $this->render('main/home.html.twig');
    }

    /**
     * @Route ("/about", name="about")
     */
    public function about()
    {
        return $this->render('main/about.html.twig');
    }
}
