<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 02.10.18
 * Time: 15:03
 */
declare(strict_types=1);
namespace App\Controller;

use App\Entity\Token;
use App\Form\UserType;
use App\Entity\User;
use App\Service\MailSender;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Category;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration", name="userRegistration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncode, \Swift_Mailer $mailer)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $userRep = $this->getDoctrine()->getRepository(User::class);

            $check = $userRep->getUserByUsername($user->getUsername());

            if($check){
                $form->get("username")->addError(new FormError('Username used'));
                return $this->render(
                    'registration/registration.html.twig',
                    array('form'=>$form->createView())
                );
            }

            $check = $userRep->getUserByEmail($user->getEmail());

            if($check){
                $form->get("email")->addError(new FormError('Email used'));
                return $this->render(
                    'registration/registration.html.twig',
                    array('form'=>$form->createView())
                );
            }

            $token = new Token("REGISTRATION");
            $user->addToken($token);
            $user->setPassword($passwordEncode->encodePassword($user, $user->getPlainPassword()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($token);
            $em->persist($user);
            $em->flush();

            $mailSender = new MailSender(
                $request->getSchemeAndHttpHost().'/registration/mail/'.$token->getToken(),
                $user->getEmail(),
                $user->getName(),
                "Verification");
            $mailSender->sendMail($mailer, $this);

            return $this->render('registration/sendEmailMessage.html.twig');
        }

        return $this->render(
            'registration/registration.html.twig',
            array('form'=>$form->createView())
        );
    }

    /**
     * @Route("/registration/mail/{tokenStr}", name="mailVerificationRegistration")
     */
    public function mailVerification(string $tokenStr)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->getUserByToken($tokenStr, 'REGISTRATION');

        $token = $this->getDoctrine()
            ->getRepository(Token::class)
            ->findOneBy([
                'token' => $tokenStr,
                'type' => 'REGISTRATION',
                'used' => false]);

        if(!$user || !$token){
            throw $this->createNotFoundException('Invalid token');
        }

        $user->setIsActive(true);
        $token->setUsed(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($token);
        $em->persist($user);
        $em->flush();

        return $this->render('registration/success.html.twig');
    }


}