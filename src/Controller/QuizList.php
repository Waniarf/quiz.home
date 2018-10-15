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
        $gameRep = $this->getDoctrine()->getRepository(Game::class);
        $quizRep = $this->getDoctrine()->getRepository(Quiz::class);
        $quiz = $quizRep->findAll();
        $data = [];
        foreach ($quiz as $key => $value){
            $leaders = $gameRep->getQuizLeaders($value->getId(), 1);
            $gameCount = $gameRep->getCountGame($value->getId());
            $data[$value->getId()] = [
                'gameCount' => $gameCount,
                'leaders' => $leaders,
                'quiz' => $value
            ];
        }
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1), 5
        );
        return $this->render(
            'quiz/quizList.html.twig',
            ['quiz' => $result]
        );
    }
}