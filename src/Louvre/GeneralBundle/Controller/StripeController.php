<?php

namespace Louvre\GeneralBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Ce contrôleur simule  une commande faites par un client.
 * Class StripeController
 */
class StripeController extends Controller
{
    
    public function prepareAction()
    {
        return $this->render('@General/Default/stripe.html.twig');
    }

    public function checkoutAction(Request $request)
    {
        \Stripe\Stripe::setApiKey("SK_PUBLIC_TEST_API");

        // Obtention des infos de carte bancaire soumises avec le formulaire
        $token = $_POST['stripeToken'];

        // Créer une charge: cela va charger la carte de l'utilisateur
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => 1000, // Montant en centimes
                "currency" => "eur",
                "source" => $token,
                "description" => "Paiement Billetterie Le Louvre"
            ));
            $this->addFlash("success","Votre paiement a été accepté !");
            return $this->redirectToRoute("order_prepare");
        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("error","Paiement refusé :(");
            return $this->redirectToRoute("order_prepare");
            // La carte a été refusée
        }
    }
}
