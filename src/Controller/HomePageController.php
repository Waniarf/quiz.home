<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 09.10.18
 * Time: 23:54
 */

namespace App\Controller;


use App\Entity\Game;
use App\Entity\Quiz;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends Controller
{
    /**
     * @Route("/", name="homePage")
     */
    public function homePage(Request $request)
    {
        return $this->render(
            'homepage/homepage.html.twig'
        );
    }
}