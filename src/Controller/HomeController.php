<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
