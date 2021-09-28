<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalController extends AbstractController
{
    /**
     * @Route("/mention-legal", name="legal")
     */
    public function index(): Response
    {
        return $this->render('legal/index.html.twig');
    }
}
