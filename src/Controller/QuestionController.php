<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
use App\Repository\CapsulerRepository;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @Route("/question/list/{tagId}", name="question_list")
     */
    public function list (QuestionRepository $questionRepository, $tagId=0)
    {
        // if ($tagId != null) {
        //     $questions = $questionRepository->findByTagId($tagId);
        // }
        $questions = $questionRepository->findAll();
        return $this->render('question/list.html.twig', [
            'questions' => $questions
        ]);
    }

    /**
     * @Route("/question/add", name="question_add")
     */

    public function add (Request $request, CapsulerRepository $capsulerRepository)
    {
        $newQuestion = new Question();
        $form = $this->createForm(QuestionType::class, $newQuestion);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $oauthUser = $this->get('session')->get('user');
            $characterOwnerHash = $oauthUser->getCharacterOwnerHash();
            $capsuler = $capsulerRepository->findOneBy(['characterOwnerHash' => $characterOwnerHash]);
            $newQuestion->setCapsuler($capsuler);
            $newQuestion->setCreatedAt(new \DateTime());
            $em->persist($newQuestion);
            $em->flush();

            return $this->redirectToRoute('question_list');
        }

        return $this->render('question/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
