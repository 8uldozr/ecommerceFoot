<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}


// IdField::new('id'),
//             DateTimeField::new('createdAt','Passé le :'),
//             TextField::new('user.lastname', 'Nom de famille'),
//             TextField::new('user.firstname', 'Nom de famille'),
//             MoneyField::new('total')->setCurrency('EUR'),
//             BooleanField::new('isPaid', 'Payée')
// carrier controller video 54 27min