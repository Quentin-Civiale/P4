<?php

namespace Louvre\GeneralBundle\Controller;

use Louvre\GeneralBundle\Entity\Commande;
use Louvre\GeneralBundle\Entity\Ticket;
use Louvre\GeneralBundle\Form\commandeType;
use Louvre\GeneralBundle\Form\ticketType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;



class CommandeController extends Controller
{
    public function commandeFormulaireAction(Request $request)
    {
        //on crée une commande
        $commande = new Commande();
        
        //on récupère le formulaire
        $form = $this->createForm(commandeType::class, $commande);
        
        //requête lors de l'envoi du formulaire
        $form->handleRequest($request);

        //si le formulaire a été soumis
        if($form->isSubmitted() && $form->isValid())
        {
//            Statut de la commande
            /** @var $commande Commande **/
            $commande = $form->getData();
            $commande->setStatut(Commande::STATUT_EN_ATTENTE_DE_PAIEMENT);

//            dump(Commande::STATUT_EN_ATTENTE_DE_PAIEMENT);

//            Calcul du prix du ticket
            /** @var $commande Commande **/
            $commande = $form->getData();
            $totalPrix = 0;

            /** @var $ticket Ticket **/
            foreach($commande->getTickets() as $ticket) {
                $prixTicket = $this->calculerPrixTicketAction($ticket);

                $ticket->setPrix($prixTicket);

                $totalPrix += $prixTicket;
            }

            $commande->setPrixTotal($totalPrix);

            //on enregistre la commande en bdd
            $em = $this->getDoctrine()->getManager();
            //préparation à l'insertion dans la bdd
            $em->persist($commande);
            //envoi vers la bdd
            $em->flush();

            return new Response('Commande enregistrée !');
        }
        
        //on génère le html du formulaire
        $formView = $form->createView();

        //on rend la vue
        return $this->render('@General/Default/commande.html.twig', array ('form' => $formView));
    }
    
    
    public function commandeRecapAction()
    {
        $repository = $this->getDoctrine()->getRepository('GeneralBundle:Commande');

        $commande = $repository->findAll();

        return $this->render('@General/Default/recapCommande.html.twig', array('commande'=> $commande));
    }
//
//    public function editAction(Request $request, Commande $commande)
//    {
//         //on récupère le formulaire
//        $form = $this->createForm(commandeType::class, $commande);
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
//            return new Response('Commande modifiée !');
//        }
//
//        //on génère le html du formulaire
//        $formView = $form->createView();
//
//        //on rend la vue
//        return $this->render('@General/Default/commande.html.twig', array ('form' => $formView));
//    }
//
//    public function deleteAction(Commande $commande)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $em->remove($commande);
//        $em->flush();
//
//        return new Response('Commande supprimée');
//    }

    private function calculerPrixTicketAction(Ticket $ticket): int
    {
        /** @var $dateDeNaissance \DateTime **/
        $dateDeNaissance = $ticket->getDateNaissance();
        $to = new \DateTime('today');
        $age = $dateDeNaissance->diff($to)->y;
        $tarif = 0;

        /** @var $tarifReduit Ticket **/

        if ($ticket->isTarifReduit()) {

            //Tarif réduit pour les personnes ayant un justificatif
            $tarif = 10;
        }
        else {

            // Tarif gratuit avant 4 ans
            if($age >= 4 && $age < 12){
                $tarif = 8;
            }
            elseif($age >= 12 && $age < 60){
                $tarif = 16;
            }
            else($age > 60) {
                $tarif = 12
            };
        }

        return $tarif;
    }
    
}
