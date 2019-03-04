<?php

namespace Louvre\GeneralBundle\Controller;

use Louvre\GeneralBundle\Entity\Booking;
use Louvre\GeneralBundle\Entity\Ticket;
use Louvre\GeneralBundle\Form\bookingType;
use Louvre\GeneralBundle\Services\TicketPriceCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends Controller
{
    /**
     * @var TicketPriceCalculator
     */
    private $ticketPriceCalculator;

    public function __construct(TicketPriceCalculator $ticketPriceCalculator)
    {
        $this->ticketPriceCalculator = $ticketPriceCalculator;
    }

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
        if ($form->isSubmitted() && $form->isValid()) {
            //Statut de la commande
            /** @var $booking Booking */
            $booking = $form->getData();
            $booking->setStatut(Booking::STATUT_EN_ATTENTE_DE_PAIEMENT);

//            $user = $this->getUser();

//            dump(Booking::STATUT_EN_ATTENTE_DE_PAIEMENT);

            //Calcul du prix du ticket
            $totalPrix = 0;

            /** @var $ticket Ticket */
            foreach ($booking->getTickets() as $ticket) {
                $prixTicket = $this->ticketPriceCalculator->calculate($ticket, $booking, $this->container);

                $ticket->setPrix($prixTicket);

                $totalPrix += $prixTicket;
            }

            $booking->setPrixTotal($totalPrix);
//            $booking->setUser($user);

            // Récupération du nombre de ticket par jour selon la date de commande
            $ticketTotalCount = $this->getDoctrine()->getRepository('GeneralBundle:Ticket')->getTodayTicketsCount($booking->getDate());

            // Changement du string en int pour le comparer à $limitTicket
            $ticketTotalCount = $ticketTotalCount + 0;

            // Limite de tickets(de visites) par jour au musée
            $limitTicket = 5;

            if ($ticketTotalCount >= $limitTicket) {
                $this->addFlash('error', 'Le nombre maximum de visiteurs pour cette date est atteint, veuillez sélectionner une nouvelle date !');
            } else {
                //on enregistre la commande en bdd
                $em = $this->getDoctrine()->getManager();
                //préparation à l'insertion dans la bdd
                $em->persist($booking);
                //envoi vers la bdd
                $em->flush();

                //ajout d'un message lors de l'enregistrement d'une commande
                $this->addFlash('notice', 'Votre commande a bien été enregistrée !');

                return $this->redirectToRoute('recapitulatif', [
                    'id' => $booking->getId(),
                ]);
            }
        }

        //on génère le html du formulaire
        $formView = $form->createView();

        //on rend la vue
        return $this->render('@General/Default/booking.html.twig', ['form' => $formView]);
    }

    public function checkingDateAction($date)
    {
        $repository = $this->getDoctrine()->getRepository('GeneralBundle:Booking');
        $formatTypeDate = new \DateTime($date);
        $visitDate = $repository->findBy(['date' => $formatTypeDate]);

        $repository = $this->getDoctrine()->getRepository('GeneralBundle:Ticket');
        $formatTypeDate = new \DateTime($date);
        $ticketTotalCount = $repository->getTodayTicketsCount($formatTypeDate);

        $limitTicket = 5;

        $availableTicket = $limitTicket - $ticketTotalCount;

        if ($ticketTotalCount >= $limitTicket) {
            $data = '{"available" :0}';
        } else {
            $data = '{"available" :'.$availableTicket.'}';
        }

        $response = new Response();
        $response->setContent($data);

        return $response;
    }
}
