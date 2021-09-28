<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\Product;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    /**
     * @Route("/commande/create-session/{reference}", name="stripe_create_session")
     */
    public function index(EntityManagerInterface $entityManager, Cart $cart, $reference)
    {   
        
        $product_for_stripe = [];
        $YOUR_DOMAIN = 'https://127.0.0.1:8000';

        $order =$entityManager->getRepository(Order::class)->findOneByReference($reference);

        if(!$order) {
            new JsonResponse(['error' => 'order']);
        }

        foreach ($order->getOrderDetails()->getValues() as $product) {

            $product_object = $entityManager->getRepository(Product::class)->findOneByName($product->getProduct());
            $product_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product->getPrice(),
                    'product_data' => [
                    'name' => $product->getProduct(),
                    'images' =>[$YOUR_DOMAIN."/uploads/files/".$product_object->getPicture()],
                ],
              ],
              'quantity' => $product->getQuantity(),
            ];
        }

        $product_for_stripe[] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $order->getCarrierPrice(),
                'product_data' => [
                'name' => $order->getCarrierName(),
                'images' =>[$YOUR_DOMAIN],
            ],
          ],
          'quantity' => 1,
        ];
        
        Stripe::setApiKey('sk_test_51Jc57GESoj0rJ6dEeDYM7zYfHIQfbEP57HRhNgqGGJ6DQcEzJjFRwFb5DpzF4l4C6QABZsyEyH3w7Psa4K6f621f00k5gibpuJ');

        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' => [
                    $product_for_stripe
                ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/commande/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/commande/erreur/{CHECKOUT_SESSION_ID}',
          ]);

          $order->setStripeSessionId($checkout_session->id);
          $entityManager->flush();

          $response = new JsonResponse(['id' => $checkout_session->id]);
          return $response;
    }
}
