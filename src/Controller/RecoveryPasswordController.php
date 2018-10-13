<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 08.10.18
 * Time: 17:49
 */
declare(strict_types=1);

namespace App\Controller;


use App\Entity\Token;
use App\Entity\User;
use App\Form\RecoveryPasswordType;
use App\Service\MailSender;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RecoveryPasswordController extends AbstractController
{

    /**
     * @Route("/recovery", name="recoveryPassword")
     */
    public function recoveryPassword(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createFormBuilder()
            ->add('email', EmailType::class)
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->getUserByEmail($form->get('email')->getData());

            if(!$user){
                $form->get("email")->addError(new FormError('No user with this email found'));
                return $this->render(
                    'recovery/email.html.twig',
                    ['form' => $form->createView()]);
            }
            $token = new Token("RECOVERY");
            $user->addToken($token);

            $em = $this->getDoctrine()->getManager();
            $em->persist($token);
            $em->persist($user);
            $em->flush();

            $mailSender = new MailSender(
                $request->getSchemeAndHttpHost().'/recovery/'.$token->getToken(),
                $user->getEmail(),
                $user->getName(),
                "Recovery");
            $mailSender->sendMail($mailer, $this);

            return $this->render('recovery/sendEmailMessage.html.twig');
        }

        return $this->render(
            'recovery/email.html.twig',
            ['form' => $form->createView()]);
    }

    /**
     * @Route("/recovery/{tokenStr}", name="mailVerificationRecovery")
     */
    public function mailVerification(Request $request, UserPasswordEncoderInterface $encoder, $tokenStr)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->getUserByToken($tokenStr, 'RECOVERY');

        $token = $this->getDoctrine()
            ->getRepository(Token::class)
            ->findOneBy([
                'token' => $tokenStr,
                'type' => 'RECOVERY',
                'used' => false]);
        if(!$user || !$token){
            throw $this->createNotFoundException('Invalid token');
        }

        $form = $this->createForm(RecoveryPasswordType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $token->setUsed(true);
            $user->setPassword($encoder->encodePassword($user, $user->getPlainPassword()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($token);
            $em->persist($user);
            $em->flush();

            return $this->render('recovery/success.html.twig');
        }

        return $this->render(
            'recovery/recovery.html.twig',
            ['form' => $form->createView()]
        );
    }
}