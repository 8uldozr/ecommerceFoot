<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

//controller pour afficher la page d'accueil
class HomeController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {

        $this->entityManager =$entityManager;

    }
    
    /**
     * @Route("/", name="home")
     */
    public function index(): Response //on attend une réponse - bonne pratique
    {
        $products = $this->entityManager->getRepository(Product::class)->findByIsBest(1);
        
        return $this->render('home/index.html.twig',[
            'products' => $products
        ]);
    }
}
