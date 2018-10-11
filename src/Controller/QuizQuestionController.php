<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 11.10.18
 * Time: 8:48
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class QuizQuestionController extends AbstractController
{
    /**
     * @Route("/quiz/{id}/{questionId}", name="quizGame")
     */
    public function quizGame()
    {

    }
}