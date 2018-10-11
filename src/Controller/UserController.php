<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\QuizRepository;
use App\Repository\UserRepository;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/user", name="user")
     */
    public function index(UserRepository $userRepository)
    {
       $users = $userRepository->findAll();

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/user/{id}", name="userinfo", requirements={"id"="\d+"})
     */
    public function show(UserRepository $userRepository, $id)
    {
        $user = $userRepository->findOneBy(['id'=> $id]);

        return $this->render('user/info.html.twig', [
            'controller_name' => 'UserController',
            'user' => $user,
        ]);
    }

    /**
     * @Route("/admin/user/edit/{id}", name="useredit", requirements={"id"="\d+"})
     */
    public function edit(UserRepository $userRepository, $id)
    {
        // creates a task and gives it some dummy data for this example
        $user = $userRepository->findOneBy(['id' => $id]);


        $form = $this->createFormBuilder($user)
            ->add('Name', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create User'])
            ->getForm();

        return $this->render('user/info.html.twig', array(
            'controller_name' => 'NewUser',
            'user' => $user,
            'form' => $form->createView(),
        ));
    }






}
