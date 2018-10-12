<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 11.10.18
 * Time: 8:48
 */

namespace App\Controller;


use App\Entity\Answers;
use App\Entity\Game;
use App\Entity\Question;
use App\Entity\QuestionOption;
use App\Entity\Quiz;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class QuizQuestionController extends AbstractController
{
    /**
     * @Route("/quiz/{id}", name="quizGame")
     * @ParamConverter("quiz", options={"id" = "id"})
     */
    public function quizGame(Quiz $quiz, Request $request)
    {
        $user = $this->getUser();

        $game = $this->getDoctrine()
            ->getRepository(Game::class)
            ->getGame($quiz->getId(), $user->getId());

        if($game === null){
            $game = new Game($quiz, $user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($game);
            $em->flush();
        }

        if($game->getTimeEnd() !== null)
            return $this->render('quiz/quizLeaders.html.twig');

        $answersNum = $this->getDoctrine()
            ->getRepository(Answers::class)
            ->getCountAnswers($game->getId());

        $question = $this->getDoctrine()
            ->getRepository(Question::class)
            ->getQuestionByNum($quiz->getId(), $answersNum);


        $options = $this->getDoctrine()
            ->getRepository(QuestionOption::class)
            ->getOptions($question->getId());


        return $this->render('quiz/quizQuestion.html.twig',
            [
                'question'=>$question,
                'options'=>$options,
                'quiz'=>$quiz
            ]);
    }

    /**
     * @Route("/quiz/{id}/check", name="answerCheck")
     * @ParamConverter("quiz", options={"id" = "id"})
     */
    public function checkAnswer(Quiz $quiz, Request $request)
    {
        $user = $this->getUser();

        $game = $this->getDoctrine()
            ->getRepository(Game::class)
            ->getGame($quiz->getId(), $user->getId());

        $answersNum = $this->getDoctrine()
            ->getRepository(Answers::class)
            ->getCountAnswers($game->getId());

        $question = $this->getDoctrine()
            ->getRepository(Question::class)
            ->getQuestionByNum($quiz->getId(), $answersNum);


        $option = $this->getDoctrine()
            ->getRepository(QuestionOption::class)
            ->findOneBy([
                'id' => $request->request->get('optionId')
            ]);

        $answer = new Answers($game, $question, $option->getIsValid());

        if($option->getIsValid())
        {
            $game->setScore($game->getScore()+1);
        }

        $questionNum = $this->getDoctrine()
            ->getRepository(Question::class)
            ->getCountQuestionInQuiz($quiz->getId());

        if($questionNum === $answersNum+1)
        {
            $game->setTimeEnd(new \DateTime());
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($game);
        $em->persist($answer);
        $em->flush();
        return new JsonResponse(['result'=>$option->getIsValid()]);
    }

}