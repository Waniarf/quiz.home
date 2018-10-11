<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Quiz;
use App\Form\EditQuizType;
use App\Form\QuizType;
use App\Repository\QuestionRepository;
use App\Repository\QuizRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use http\Env\Request;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @method createQueryBuilder(string $string)
 */
class QuizController extends AbstractController
{
    /**
     * @Route("admin/quiz", name="quiz")
     */
    public function index(QuizRepository $quizRepository)
    {
        $quizs = $quizRepository->findAll();

        return $this->render('quiz/index.html.twig', [
            'controller_name' => 'QuizController',
            'quizs' => $quizs,
        ]);
    }

    /**
     * @Route("admin/quiz/new", name="quiz_new")
     */
    public function new(\Symfony\Component\HttpFoundation\Request $request)
    {
        $quiz = new Quiz();
        $time = new \DateTimeImmutable();
        $quiz->setCreateData($time);
        $quiz->setIsActive(false);
        $form = $this->createForm(QuizType::class, $quiz);

        $form->handleRequest($request);


        if ($form->isSubmitted() ) {
            $quiz = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($quiz);
            $em->flush();
            $id = $quiz->getId();
            return $this->redirectToRoute('quiz_edit', array('id' => $id));
        }

        return $this->render('quiz/new.html.twig', [
            'controller_name' => 'QuizController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/quiz/edit/{id}", name="quiz_edit")
     */
    public function edit(\Symfony\Component\HttpFoundation\Request $request, $id, QuizRepository $quizRepository, QuestionRepository $questionRepository)
    {
        $quiz = $quizRepository->find($id);
        $questions = $quiz->getQuestion()->toArray();

        $form = $this->createForm(EditQuizType::class, $quiz);
        $form->handleRequest($request);
        if ($form->isSubmitted() ) {
            $questionId = $form['question']->getViewData();
            $question = $questionRepository->find(['id' => $questionId]);
            $quiz->addQuestion($question);
            $em = $this->getDoctrine()->getManager();
            $em->flush();

                return $this->redirectToRoute('quiz_edit', array('id' => $id));
            }
        return $this->render('quiz/edit.html.twig', [
            'controller_name' => 'QuizController',
            'form' => $form->createView(),
            'questions' => $questions,

        ]);
    }

}
