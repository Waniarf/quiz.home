<?php

namespace App\Controller;

use App\Repository\AnswersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AnswerController extends AbstractController
{
    /**
     * @Route("/admin/answer", name="answer")
     */
    public function index(AnswersRepository $answersRepository)
    {
        $answers = $answersRepository->findAll();
        return $this->render('answer/index.html.twig', [
            'controller_name' => 'AnswerController',
            'answers' => $answers,
        ]);
    }
}
