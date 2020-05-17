<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    /**
     * @Route("/character/details", name="character_details")
     */
    public function details()
    {   
    

        return $this->render('character/details.html.twig', [
            
        ]);
    }
}
