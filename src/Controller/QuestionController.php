<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Form\AnswerType;
use App\Form\QuestionType;
use App\Repository\CapsulerRepository;
use App\Repository\QuestionRepository;
use App\Services\AuthChecker;
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

    /**
     * @Route("/question/{id}", name="question_read", requirements={"id"="\d+"})
     */
    public function read(Question $question, AuthChecker $authChecker, Request $request, CapsulerRepository $capsulerRepository)
    {
        if ($authChecker->isAuthenticated()) {
            
            // dump($question->getCapsuler());

            $newAnswer = new Answer();
            $form = $this->createForm(AnswerType::class, $newAnswer);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $oauthUser = $this->get('session')->get('user');
            $characterOwnerHash = $oauthUser->getCharacterOwnerHash();
            $capsuler = $capsulerRepository->findOneBy(['characterOwnerHash' => $characterOwnerHash]);
            $newAnswer->setCapsuler($capsuler);
            $newAnswer->setCreatedAt(new \DateTime());
            $newAnswer->setQuestion($question);
            $em->persist($newAnswer);
            $em->flush();

            return $this->redirectToRoute('question_read', ['id' => $question->getId()]);
            }


            return $this->render('question/read.html.twig', [
                'question' => $question,
                'form' => $form->createView()
            ]);
        
        } else {
            return $this->redirectToRoute('main_home');
        }
    }

}
