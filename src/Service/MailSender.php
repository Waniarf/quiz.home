<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 03.10.18
 * Time: 20:56
 */
declare(strict_types=1);
namespace App\Service;


class MailSender
{
    private $verificationUrl;
    private $userAddress;
    private $name;
    private $type;

    /**
     * MailSender constructor.
     * @param string $verificationUrl
     * @param string $userAddress
     * @param string $name
     */
    public function __construct(string $verificationUrl, string $userAddress, string $name, string $type)
    {
        $this->verificationUrl = $verificationUrl;
        $this->userAddress = $userAddress;
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @param \Swift_Mailer $mailer
     *
     * @return void
     */
    public function sendMail(\Swift_Mailer $mailer): void
    {
        $mail = (new \Swift_Message('Quiz verification email'))
            ->setFrom('Quiz@mail.home')
            ->setTo($this->userAddress)
            ->setBody('Hi '.$this->name.'. '.$this->type.' URL: '.$this->verificationUrl);

        $mailer->send($mail);
    }

    /**
     * @return String
     */
    public function getVerificationUrl(): String
    {
        return $this->verificationUrl;
    }

    /**
     * @param string $verificationUrl
     *
     * @return void
     */
    public function setVerificationUrl(string $verificationUrl): void
    {
        $this->verificationUrl = $verificationUrl;
    }

    /**
     * @return string
     */
    public function getUserAddress(): string
    {
        return $this->userAddress;
    }


    /**
     * @param string $userAddress
     *
     * @return void
     */
    public function setUserAddress(string $userAddress): void
    {
        $this->userAddress = $userAddress;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


}