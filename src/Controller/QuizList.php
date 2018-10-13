<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 13.10.18
 * Time: 14:44
 */

namespace App\Controller;


use App\Entity\Game;
use App\Entity\Quiz;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QuizList extends Controller
{
    /**
     * @Route("/quiz/list", name="quizList")
     */
    public function homePage(Request $request)
    {
        $quiz = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->getAllActiveQuiz();

        $data = [];
        foreach ($quiz as $key => $value){
            $q = $this->getDoctrine()
                ->getRepository(Game::class)
                ->getQuizLeaders($value->getId(), 1);

            $data[$value->getId()]['leaders'] = $q;
            $data[$value->getId()]['quiz'] = $value;
        }

        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1), 6
        );

        return $this->render(
            'quiz/quizList.html.twig',
            ['quiz' => $result]
        );
    }
}