<?php

namespace Louvre\GeneralBundle\Controller;

use Louvre\GeneralBundle\Entity\Booking;
use Louvre\GeneralBundle\Entity\Ticket;
use Louvre\GeneralBundle\Form\bookingType;
use Louvre\GeneralBundle\Form\ticketType;
use Louvre\GeneralBundle\Services\Price;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class BookingController extends Controller
{
    public function bookingFormAction(Request $request)
    {
        //on crée une commande
        $booking = new Booking();
        $booking->setDate(new \DateTime('now'));
        
        //on récupère le formulaire
        $form = $this->createForm(bookingType::class, $booking);
        
        //requête lors de l'envoi du formulaire
        $form->handleRequest($request);

        //si le formulaire a été soumis
        if($form->isSubmitted() && $form->isValid())
        {
            //Statut de la commande
            /** @var $booking Booking **/
            $booking = $form->getData();
            $booking->setStatut(Booking::STATUT_EN_ATTENTE_DE_PAIEMENT);

            $user = $this->getUser();

//            dump(Booking::STATUT_EN_ATTENTE_DE_PAIEMENT);

            //Calcul du prix du ticket
            $totalPrix = 0;

            /** @var $ticket Ticket **/
            foreach($booking->getTickets() as $ticket) {
                $prixTicket = $this->calculTicketPriceAction($ticket, $booking);

                $ticket->setPrix($prixTicket);

                $totalPrix += $prixTicket;
            }

            $booking->setPrixTotal($totalPrix);
            $booking->setUser($user);



            //on enregistre la commande en bdd
            $em = $this->getDoctrine()->getManager();
            //préparation à l'insertion dans la bdd
            $em->persist($booking);
            //envoi vers la bdd
            $em->flush();


//            // Calcul de limite de 1000 visiteurs par jour
//            $bookingId = $booking->getId();
//            $bookingDate = $booking->getDate();
//
//            $bookingListByDate = $this->getDoctrine()
//                ->getRepository('GeneralBundle:Booking')
//                ->findBy(array('date' => $booking->getDate()));
//            $bookingNumberByDate = count($bookingListByDate);
//
//            $visitorFirstName = array($ticket->getPrenom());
//
//            $dateToday = new \DateTime('now');
//
//            $ticketListByBooking = $this->getDoctrine()
//                ->getRepository('GeneralBundle:Ticket')
//                ->findBy(array('booking' => $ticket->getBooking()));
//            $totalTicketNumber = count($ticketListByBooking);
//
//            /** @var $booking Booking **/
//            foreach ($bookingListByDate as $booking) {
//                $totalTicketNumber += count($booking->getTickets());
//            }
//
////            var_dump($totalTicketNumber);
////            die();
////
////            var_dump($bookingId);
////            var_dump($bookingDate);
////
////            var_dump($bookingListByDate);
////            var_dump($bookingNumberByDate);
////
////            var_dump($visitorFirstName);
////
////            var_dump($ticketListByBooking);
////            var_dump($totalTicketNumber);
////
////            die();
//
//            if ($totalTicketNumber > 5) {
//
//                //ajout d'un message lors du dépassement de visiteurs par jour
//                $this->addFlash("error","Le nombre maximum de visiteurs pour cette date est atteint, veuillez sélectionner une nouvelle date !");
//
//                return $this->redirectToRoute("selection");
//            }
//
//
//            //ajout d'un message lors de l'enregistrement d'une commande
//            $this->addFlash("notice","Votre commande a bien été enregistrée !");
//
//            return $this->redirectToRoute('recapitulatif', [
//                'id' => $booking->getId()
//            ]);

        }
        
        //on génère le html du formulaire
        $formView = $form->createView();

        //on rend la vue
        return $this->render('@General/Default/booking.html.twig', ['form' => $formView]);
    }

    private function calculTicketPriceAction(Ticket $ticket, Booking $booking): int
    {
        /** @var $dateDeNaissance \DateTime **/
        $dateDeNaissance = $ticket->getDateNaissance();
        $to = new \DateTime('today');
        $age = $dateDeNaissance->diff($to)->y;
        $price = 0;
        $priceCoef = 1;

        /** @var $tarifReduit Ticket **/

        if ($booking->getType() == 'demi-journee') {

            $priceCoef = Price::HALF_PRICE;
        }

        switch (true){
            case $age >= 4 && $age < 12:
                $price = Price::CHILD_PRICE;
                break;
            case $age < 4:
                $price = Price::FREE_PRICE;
                break;
            case $age >= 12 && $age < 60:
                $price = Price::NORMAL_PRICE;
                break;
            case $age > 60:
                $price = Price::SENIOR_PRICE;
                break;
            default:
                break;
        }

        if ($ticket->isTarifReduit()) {

            //Tarif réduit pour les personnes ayant un justificatif
            $reducedPrice = Price::REDUCED_PRICE;
            $price = min($price, $reducedPrice);
        }

        return $price * $priceCoef;
    }

//    public function checkingNumberVisitorAction(Ticket $ticket)
//    {
//        /** @var $ticket Ticket */
//        $numberVisitor = count(array($ticket->getId()));
//        $maxVisitor = 1000;
//        $today = new \DateTime('now');
//
//        if($numberVisitor > $maxVisitor && $today) {
//
//            return new response (
//                "Impossible de réserver ce jour car la limite de visiteurs est dépassée !"
//            );
//        }
//
//        return new response (
//            "Il reste ... billets d'entrée pour aujourd'hui !"
//        );
//
//    }


}
