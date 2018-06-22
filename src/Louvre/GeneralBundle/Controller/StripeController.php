<?php

namespace Louvre\GeneralBundle\Controller;

use Louvre\GeneralBundle\Entity\Ticket;
use Louvre\GeneralBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Louvre\GeneralBundle\Entity\Booking;

class StripeController extends Controller
{
    public function prepareAction(Booking $booking, Ticket $ticket)
    {
        return $this->render('@General/Default/stripe.html.twig', [
            'booking' => $booking,
            'ticket' => $ticket
        ]);
    }

    public function checkoutAction(Booking $booking)
    {
        \Stripe\Stripe::setApiKey("sk_test_V9G72YZX893d8bKBrXH8k4Ts");

        // Obtention des infos de carte bancaire soumises avec le formulaire
        $token = $_POST['stripeToken'];

        //récupération du prix total de la commande via input de la vue
        $totalPrice = $_POST['inputValue'];

        // récupération de l'email de la commande via input de la vue
        $recipientEmail = $_POST['email'];

        // Créer une charge: cela va charger la carte de l'utilisateur
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $totalPrice, // Montant en centimes
                "currency" => "eur",
                "source" => $token,
                "description" => "Paiement Billetterie Le Louvre"
            ));

            // Gestion et envoi du mail de confirmation de commande
            $message = \Swift_Message::newInstance()
                ->setSubject('Validation de votre commande')
                ->setFrom(array('quentin.civiale@gmail.com' => "Musée du Louvre - Billetterie"))
                ->setTo($recipientEmail)
                ->setCharset('utf-8')
                ->setContentType('text/html')
                ->setBody($this->renderView("@General/Default/mail.html.twig", array('booking' => $booking)));
//                ->attach(\Swift_Attachment::fromPath('general_homepage'));

            $this->get('mailer')->send($message);

            // Redirection vers la vue et message de confirmation de paiement
            $this->addFlash("success","Votre paiement a été accepté !");
            return $this->redirectToRoute("confirmation");

        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("error","Paiement refusé !");
            return $this->redirectToRoute("order_prepare");
            // La carte a été refusée
        }
    }
}
