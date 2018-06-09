<?php

namespace Louvre\GeneralBundle\Controller;

use Louvre\GeneralBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Louvre\GeneralBundle\Entity\Booking;


class StripeController extends Controller
{
    public function prepareAction(Booking $booking)
    {
        return $this->render('@General/Default/stripe.html.twig', [
            'booking' => $booking
        ]);
    }

    public function checkoutAction(Request $request)
    {
        \Stripe\Stripe::setApiKey("sk_test_V9G72YZX893d8bKBrXH8k4Ts");

        // Obtention des infos de carte bancaire soumises avec le formulaire
        $token = $_POST['stripeToken'];

        //récupération du prix total de la commande via input de la vue
        $totalPrice = $_POST['inputValue'];

        // Créer une charge: cela va charger la carte de l'utilisateur
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $totalPrice, // Montant en centimes
                "currency" => "eur",
                "source" => $token,
                "description" => "Paiement Billetterie Le Louvre"
            ));

            // Gestion et envoi du mail de validation
            $message = \Swift_Message::newInstance()
                ->setSubject('Validation de votre commande')
                ->setFrom(array('quentin.civiale@gmail.com' => "Musée du Louvre - Billetterie"))
                ->setTo('kent.63@hotmail.fr')
                ->setCharset('utf-8')
                ->setContentType('text/html')
                ->setBody($this->renderView("@General/Default/mail.html.twig"));
//                ->attach(\Swift_Attachment::fromPath('/P4/web/img/louvre_bannière.png'));

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

//    public function sendMailAction($booking, \Swift_Mailer $mailer)
//    {
//        $message = (new \Swift_Message('Hello Email'))
//            ->setSubject('Musée du Louvre - Billetterie')
//            ->setFrom('quentin.civiale@gmail.com')
//            ->setTo($data['email'])
//            ->setBody(
//                $this->renderView(
//                    // app/Resources/views/Default/mail.html.twig
//                    '@General/Default/mail.html.twig',
//                    array('booking' => $booking)
//                ),
//                'text/html'
//            );
//
//        $mailer->send($message);
//
//        return $this->redirectToRoute("confirmation");
//    }
}
