<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\QuestionOption;
use App\Form\CreateQuestionType;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormTypeInterface;

class QuestionController extends AbstractController
{
    /**
     * @Route("admin/question", name="question")
     */
    public function index(QuestionRepository $questionRepository)
    {
        $questions = $questionRepository->findAll();
        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController',
            'questions' => $questions,
        ]);
    }

    /**
     * @Route("admin/question/info/{id}", name="question_info")
     */
    public function info(QuestionRepository $questionRepository, $id)
    {
        $question = $questionRepository->findOneBy(['id' => $id]);
        if (!$question)
        {
            return $this->redirectToRoute('question');
        }
        return $this->render('question/info.html.twig', [
            'controller_name' => 'QuestionController',
            'question' => $question,
        ]);
    }

    /**
     * @Route("admin/question/new", name="question_new")
     */
    public function new(Request $request)
    {
        $option1 = new QuestionOption();
        $option2 = new QuestionOption();
        $option3 = new QuestionOption();
        $option4 = new QuestionOption();
        $question = new Question();
        $question->addQuestionOption($option1);
        $question->addQuestionOption($option2);
        $question->addQuestionOption($option3);
        $question->addQuestionOption($option4);
        $form = $this->createForm(CreateQuestionType::class, $question);
        $form->handleRequest($request);
        if ($form->isSubmitted() ) {
            $question = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();
            return $this->redirectToRoute('question');
        }
        return $this->render('question/new.html.twig', [
            'controller_name' => 'QuestionController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/question/edit/{id}", name="question_edit")
     */
    public function edit(QuestionRepository $questionRepository, $id, Request $request)
    {
        $question = $questionRepository->findOneBy(['id' => $id]);

        if (!$question)
        {
            return $this->redirectToRoute('question');
        }
        $form = $this->createForm(CreateQuestionType::class, $question);
        $form->handleRequest($request);
        if ($form->isSubmitted() ) {

            $question = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('question');
        }

        return $this->render('question/edit.html.twig', [
            'controller_name' => 'QuestionController',
            'question' => $question,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/question/delete/{id}", name="question_delete")
     */
    public function delete(QuestionRepository $questionRepository, $id, Request $request)
    {
        $question = $questionRepository->findOneBy(['id' => $id]);
        if($request->isXmlHttpRequest())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($question);
            $em->flush();
        }
        else {
            return $this->redirectToRoute('question');
        }


    }
}
