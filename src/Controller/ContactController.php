<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Form\ContactType;
use App\Classe\ContactMail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/nous-contacter", name="contact")
     */
    public function index(Request $request): Response
    {
        $notification = null;
        
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->addFlash('notice', 'Merci de nous avoir contacter . Notre équipe va vous répondre dans les meilleurs délais.');
   
            $content = "Bonjour </br>Vous avez reçus un message de <strong>".$form->getData()['prenom']." ".$form->getData()['nom']."</strong></br>Adresse email : <strong>".$form->getData()['email']."</strong> </br>Message : ".$form->getData()['content']."</br></br>";         
            $mail = new ContactMail();
            $mail->send('mattana.florian@gmail.com', 'Footix.fr', "Quelqu'un a essayé de vous joindre.", $content);
            $notification ="Votre mail s'est parfaitement envoyé. Nous vous répondrons dès que possible.";
        }

        return $this->render('contact/index.html.twig',[
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
