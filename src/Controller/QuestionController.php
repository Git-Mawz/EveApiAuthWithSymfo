<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @Route("/question/list", name="question_list")
     */
    public function list (QuestionRepository $questionRepository)
    {
        $questions = $questionRepository->findAll();
        return $this->render('question/list.html.twig', [
            'question' => $questions
        ]);
    }

    /**
     * @Route("/question/add", name="question_add")
     */

    public function add (Request $request)
    {

        

    }

}
