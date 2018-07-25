<?php

namespace Louvre\GeneralBundle\Controller;

use Louvre\GeneralBundle\Entity\Booking;
use Louvre\GeneralBundle\Entity\Ticket;
use Louvre\GeneralBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        $token = $request->request->get('stripeToken');

        // récupération des infos de la commande via input de la vue
        $bookingId = $request->request->get('id');
        $bookingFirstName = $request->request->get('firstName');
        $bookingLastName = $request->request->get('lastName');
        $bookingVisitDate = $request->request->get('visitDate');
        $bookingVisitType = $request->request->get('visitType');
        $recipientEmail = $request->request->get('email');
        $totalPrice = $request->request->get('totalPrice');
        $statut = $request->request->get('statut');

        $price = $totalPrice/100;

        // Créer une charge: cela va charger la carte de l'utilisateur
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $totalPrice, // Montant en centimes
                "currency" => "eur",
                "source" => $token,
                "description" => "Paiement Billetterie Le Louvre",
                "metadata" => array(
                    "booking_id" => $bookingId,
                    "booking_first_name" => $bookingFirstName,
                    "booking_last_name" => $bookingLastName,
                    "booking_visit_date" => $bookingVisitDate,
                    "booking_visit_type" => $bookingVisitType,
                    "booking_email" => $recipientEmail,
                    "booking_total_price" => ($totalPrice/100),
                    "booking_statut" => $statut
                )
            ));

            // vérifier que charge a la clé paid à true

            // maj du statut booking

            // associer l'id de transaction stripe à l'objet booking


            // Gestion et envoi du mail de confirmation de commande
            $message = \Swift_Message::newInstance()
                ->setSubject('Validation de votre commande')
                ->setFrom(array('quentin.civiale@gmail.com' => "Musée du Louvre - Billetterie"))
                ->setTo($recipientEmail)
                ->setCharset('utf-8')
                ->setContentType('text/html')
                ->setBody("<h3>Musée du Louvre</h3>
                                 <h4>Confirmation d'achat de vos billets d'entrée au Musée du Louvre</h4>
                                 <p>Bonjour $bookingFirstName $bookingLastName,<br/>
                                  Nous vous confirmons votre achat de billet(s) d'entrée au Louvre pour le $bookingVisitDate pour la somme de $price €.<br/><br/>
                                  Merci de votre achat et nous vous souhaitons une bonne visite au sein du Musée du Louvre.</p>
                                  <p>Vous trouverez ci-dessous vos billets, imprimables ou sur présentation de ce mail auprès de nos agents d'accueil.</p>
                                  <hr/>
                                  <p><h3>Récapitulatif de votre commande</h3>
                                  <strong>Nom :</strong> $bookingLastName <br/>
                                  <strong>Prénom :</strong> $bookingFirstName <br/>
                                  <strong>Date de la visite :</strong> le $bookingVisitDate en <strong>$bookingVisitType</strong> <br/>
                                  <strong>Email :</strong> $recipientEmail <br/>
                                  <strong>Statut de la commande :</strong> $statut <br/>
                                  <strong>Prix total de la commande :</strong> $price €<br/><br/></p>
                                  
                                  <table class=\"centered responsive-table\">
                                  <thead>
                                  <tr>
                                  <th>Nom</th>
                                  <th>Prénom</th>
                                  <th>Date de naissance</th>
                                  <th>Réduction</th>
                                  <th>Tarifs</th>
                                  <th>Numéro de la commande</th>
                                  </tr>
                                  </thead>
                                
                                  {% for ticket in ticket %}
                                  <tbody>
                                  <tr>
                                  <td> {{ ticket.nom }} </td>
                                  <td> {{ ticket.prenom }} </td>
                                  <td> {{ ticket.dateNaissance|date('d/m/Y') }} </td>
                                  <td> {{ ticket.tarifReduit }} </td>
                                  <td> {{ ticket.prix }} € </td>
                                  <td> $bookingId </td>
                                  </tr>
                                  </tbody>
                                  {% endfor %}
                                
                                  <tbody>
                                  <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td><strong>Total</strong></td>
                                  <td><strong> $price € </strong></td>
                                  </tr>
                                  </tbody>
                                  </table>
                                ");
//                ->setBody($this->renderView("@General/Default/mail.html.twig"));
//                ->attach(\Swift_Attachment::fromPath('general_homepage'));

            $this->get('mailer')->send($message);

            // Redirection vers la vue et message de confirmation de paiement
//            $this->addFlash("success","Votre paiement a été accepté !");

            return $this->redirectToRoute("confirmation");

        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("error","Paiement refusé !");
            return $this->redirectToRoute("order_prepare");
            // La carte a été refusée
        }
    }

}

//, [
//    'id' => $booking->getId()
//]