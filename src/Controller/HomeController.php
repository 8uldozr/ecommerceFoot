<?php

namespace App\Controller;

use App\Classe\Mail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

//controller pour afficher la page d'accueil
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response //on attend une réponse - bonne pratique
    {
        return $this->render('home/index.html.twig');
    }
}
