<?php

namespace Louvre\GeneralBundle\Controller;

use Louvre\GeneralBundle\Entity\Booking;
use Louvre\GeneralBundle\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StripeController extends Controller
{
    public function prepareAction(Booking $booking, Ticket $ticket)
    {
        return $this->render('@General/Default/stripe.html.twig', [
            'booking' => $booking,
            'ticket' => $ticket,
        ]);
    }

    public function checkoutAction(Request $request, Booking $booking, Ticket $ticket)
    {
        $repository = $this->getDoctrine()->getRepository('GeneralBundle:Ticket');
        $ticket = $repository->findBy(['booking' => $booking->getId()]);

        \Stripe\Stripe::setApiKey($this->getParameter('stripe_secret_key'));

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
//        $statut = $request->request->get('statut');

        $price = $totalPrice / 100;

        // Créer une charge: cela va charger la carte de l'utilisateur
        try {
            $charge = \Stripe\Charge::create([
                'amount' => $totalPrice, // Montant en centimes
                'currency' => 'eur',
                'source' => $token,
                'description' => 'Paiement Billetterie Le Louvre',
                'metadata' => [
                    'booking_id' => $bookingId,
                    'booking_first_name' => $bookingFirstName,
                    'booking_last_name' => $bookingLastName,
                    'booking_visit_date' => $bookingVisitDate,
                    'booking_visit_type' => $bookingVisitType,
                    'booking_email' => $recipientEmail,
                    'booking_total_price' => ($totalPrice / 100),
//                    "booking_statut" => $statut
                ],
            ]);

            // vérifier que charge a la clé paid à true
            if ($charge->paid == true) {
                // maj du statut de la commande booking
                /* @var $booking Booking **/
                $booking->setStatut(Booking::STATUT_PAIEMENT_ACCEPTE);

                // associer l'id de transaction stripe à l'objet booking
//                $charge->id;
            }

            // Gestion et envoi du mail de confirmation de commande
            $message = \Swift_Message::newInstance()
                ->setSubject('Validation de votre commande')
                ->setFrom(['quentin.civiale@gmail.com' => 'Musée du Louvre - Billetterie'])
                ->setTo($recipientEmail)
                ->setCharset('utf-8')
                ->setContentType('text/html')
                ->setBody($this->renderView('@General/Default/mail.html.twig', [
                    'booking' => $booking,
                    'ticket' => $ticket,
                ]));
//                ->attach(\Swift_Image::fromPath('....jpg'));

            $this->get('mailer')->send($message);

            // Redirection vers la vue et message de confirmation de paiement
//            $this->addFlash("success","Votre paiement a été accepté !");

            return $this->redirectToRoute('confirmation', [
                'id' => $booking->getId(),
            ]);
        } catch (\Stripe\Error\Card $e) {
            $this->addFlash('error', 'Paiement refusé !');

            return $this->redirectToRoute('order_prepare');
            // La carte a été refusée
        }
    }
}
