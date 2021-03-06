<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager =$entityManager;
    }

    // video 15 8min


    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {

        $notification = null;

        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $search_email =$this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());

            if(!$search_email){

                $user = $form->getData();

                $password = $encoder->encodePassword($user, $user->getPassword());

                $user->setPassword($password);

                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $mail = new Mail();
                $content ="Bonjour".$user->getFirstname()."<br/> Bienvenue sur le site numéro de vente de maillot de foot<br/><br/>" ;
                $mail->send($user->getEmail(),$user->getFirstname(), "Bienvenue sur footix.fr", $content);

                $notification ="Votre inscription s'est parfaitement déroulée, vous pouvez vous connecter à votre compte";

            } else {

                $notification ="Un compte associé à cette email existe déjà" ;

            }


        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
            ]);
    }
}
