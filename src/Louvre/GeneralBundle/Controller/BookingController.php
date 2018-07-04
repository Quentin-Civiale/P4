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

//            /** @var $booking Booking **/
//            foreach($booking->getDate() as $booking) {
//                $checkDate = $this->checkingDateAction($booking);
//
//                $booking->setDate($checkDate);
//
//            }

            //on enregistre la commande en bdd
            $em = $this->getDoctrine()->getManager();
            //préparation à l'insertion dans la bdd
            $em->persist($booking);
            //envoi vers la bdd
            $em->flush();

            //ajout d'un message lors de l'enregistrement d'une commande
            $this->addFlash("notice","Votre commande a bien été enregistrée !");

            return $this->redirectToRoute('recapitulatif', [
                'id' => $booking->getId()
            ]);

        }
        
        //on génère le html du formulaire
        $formView = $form->createView();

        //on rend la vue
        return $this->render('@General/Default/booking.html.twig', ['form' => $formView]);
    }
    
    
//    public function bookingSummaryAction()
//    {
//        $repository = $this->getDoctrine()->getRepository('GeneralBundle:Booking');
//
//        $commande = $repository->findAll();
//
//        return $this->render('@General/Default/bookingSummary.html.twig', array('commande'=> $commande));
//    }
//
//    public function editAction(Request $request, Booking $commande)
//    {
//         //on récupère le formulaire
//        $form = $this->createForm(bookingType::class, $commande);
//
//        //requête lors de l'envoi du formulaire
//        $form->handleRequest($request);
//
//        //si le formulaire a été soumis
//        if($form->isSubmitted() && $form->isValid())
//        {
//            //on enregistre la commande en bdd
//            $em = $this->getDoctrine()->getManager();
//
//            //envoi vers la bdd
//            $em->flush();
//
//            return new Response('Booking modifiée !');
//        }
//
//        //on génère le html du formulaire
//        $formView = $form->createView();
//
//        //on rend la vue
//        return $this->render('@General/Default/booking.html.twig', array ('form' => $formView));
//    }
//
//    public function deleteAction(Booking $commande)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $em->remove($commande);
//        $em->flush();
//
//        return new Response('Booking supprimée');
//    }

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

    private function checkingDateAction(Booking $booking)
    {
        /** @var $date \DateTime **/
        $dateVisit = $booking->getDate();
        $dateToday = new \DateTime('now');
        $hour = new \DateTime('14:00:00');
        $day = $booking->getType('journee');
        $halfDay = $booking->getType('demi-journee');

        if ($dateVisit == $dateToday && $dateToday > $hour ) {

            return $halfDay;
        }
        else ($dateVisit != $dateToday);

        return $day and $halfDay;
    }

    private function checkingNumberVisitorAction(Ticket $ticket)
    {
        /** @var $ticket Ticket */
        $numberVisitor = count(array($ticket->getId()));
        $maxVisitor = 1000;
        $today = new \DateTime('now');

        if($numberVisitor > $maxVisitor && $today) {

            return new response (
                "Impossible de réserver ce jour car la limite de visiteurs est dépassée !"
            );
        }

        return new response (
            "Il reste ... billets d'entrée pour aujourd'hui !"
        );

    }

}
