<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Classe\OrderMail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderValidateController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager =$entityManager;
    }
    
    /**
     * @Route("/commande/merci/{stripeSessionId}", name="order_validate")
     */
    public function index($stripeSessionId, Cart $cart): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if(!$order || $order->getUser() != $this->getUser()){
            return $this->redirectToRoute('home');
        }


        if($order->getState() == 0 ){
            $cart->remove();
            $order->setState(1);
            $this->entityManager->flush();

            $mail = new OrderMail();
            $content ="Bonjour".$order->getUser()->getFirstname()."<br/> Merci pour votre commande <br/><br/>" ;
            $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), "Votre commande sur footix.fr est validée", $content);
        }

        return $this->render('order_validate/index.html.twig', [
            'order' => $order
        ]);

    }
}
