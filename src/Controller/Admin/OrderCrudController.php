<?php

namespace App\Controller\Admin;

use App\Classe\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManager;

use Doctrine\ORM\EntityManagerInterface;
use App\Controller\Admin\OrderCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\TextEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderCrudController extends AbstractCrudController
{
    private $entityManager;
    private $crudUrlGenerator;

    public function __construct(EntityManagerInterface $entityManager, CrudUrlGenerator $crudUrlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->crudUrlGenerator = $crudUrlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureCrud($crud): Crud
    {
        return $crud->setDefaultSort(['id' => 'DESC']);
    }

    public function configureActions($actions): Actions
    {
        $updatePreparation = Action::new('updatePreparation', ' Préparation en cours','fas fa-box-open')->linkToCrudAction('updatePreparation');
        $updateDelivery = Action::new('updateDelivery', 'Livraison en cours |', 'fas fa-truck')->linkToCrudAction('updateDelivery');

        return $actions
        ->add('detail', $updatePreparation)
        ->add('detail', $updateDelivery)
        ->add('index', 'detail');
    }


    public function updatePreparation(AdminContext $context) {
            $order = $context->getEntity()->getInstance();
            $order->setState(2);
            $this->entityManager->flush();

            $this->addFlash('notice', "<strong> La commande est en cours de préparation </strong>");

            // $mail = new Mail();
            //     $content ="Bonjour".$user->getFirstname()."<br/> Bienvenue sur le site numéro de vente de maillot de foot<br/><br/>" ;
            //     $mail->send($user->getEmail(),$user->getFirstname(), "Bienvenue sur footix.fr", $content);

            $routeBuilder = $this->get(AdminUrlGenerator::class);
 
        return $this->redirect($routeBuilder->setController(OrderCrudController::class)->setAction('index')->generateUrl());
    }

    public function updateDelivery(AdminContext $context) {
            $order = $context->getEntity()->getInstance();
            $order->setState(3);
            $this->entityManager->flush();

            $this->addFlash('notice', "<strong> La commande est en cours de livraison </strong>");

            $routeBuilder = $this->get(AdminUrlGenerator::class);

    return $this->redirect($routeBuilder->setController(OrderCrudController::class)->setAction('index')->generateUrl());
    }
    
    
    
    public function configureFields(string $pageName): iterable
    {
        return [

            IdField::new('id'),
            DateTimeField::new('createdAt','Passé le :'),
            TextField::new('user.lastname', 'Nom de famille'),
            TextField::new('user.firstname', 'Nom de famille'),
            TextEditorField::new('delivery', 'Adresse de livraison')->onlyOnDetail(),
            MoneyField::new('total')->setCurrency('EUR'),
            TextField::new('carrierName', 'Transporteur'),
            MoneyField::new('carrierPrice', 'Frais de port')->setCurrency('EUR'),
            ChoiceField::new('state')->setChoices([
                'Non payée' => 0,
                'Payée' => 1,
                'Préparation en cours' => 2,
                'Livraison en cours' => 3
            ]),
            ArrayField::new('orderDetails', 'Produits achetés')->hideOnIndex()
        ];
    }
}


// https://stackoverflow.com/questions/55948523/symfony-4-object-of-class-could-not-be-converted-to-string