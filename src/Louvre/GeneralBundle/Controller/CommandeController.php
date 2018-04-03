<?php

namespace Louvre\GeneralBundle\Controller;

use Louvre\GeneralBundle\Entity\Commande;
use Louvre\GeneralBundle\Entity\Tickets;
use Louvre\GeneralBundle\Form\commandesType;
use Louvre\GeneralBundle\Form\ticketsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;



class CommandesController extends Controller
{
    public function commandesFormulaireAction(Request $request)
    {
        //on crée une commande
        $commande = new Commande();
        
        //on récupère le formulaire
        $form = $this->createForm(commandesType::class, $commande);
        
        //requête lors de l'envoi du formulaire
        $form->handleRequest($request);

        //si le formulaire a été soumis
        if($form->isSubmitted() && $form->isValid())
        {
            /** @var $commande Commande **/
            $commande = $form->getData();
            $totalPrix = 0;

            /** @var $ticket Tickets **/
            foreach($commande->getTickets() as $ticket) {

                /** @var $dateDeNaissance \DateTime **/
                $dateDeNaissance = $ticket->getDateNaissance();
                $to = new \DateTime('today');
                $age = $dateDeNaissance->diff($to)->y;
                $tarif = 0;

                dump($age);

                if($age >= 4 && $age < 12){
                    $tarif += 8;
                }
                elseif($age >= 12 && $age < 60){
                    $tarif += 16;
                }
                elseif($age > 60) {
                    $tarif += 12;
                }
                else {
                    $tarif += 10;
                }

                $totalPrix = $tarif;

                dump($totalPrix);

                $prix = $ticket->setPrix($totalPrix);

                dump($prix);
            }

//            //on enregistre la commande en bdd
//            $em = $this->getDoctrine()->getManager();
//            //préparation à l'insertion dans la bdd
//            $em->persist($commande);
//            //envoi vers la bdd
//            $em->flush();
//
//            return new Response('Commande enregistrée !');
        }
        
        //on génère le html du formulaire
        $formView = $form->createView();
        
        //on rend la vue
        return $this->render('@General/Default/commandes.html.twig', array ('form' => $formView));
    }
    
    
    public function commandes_listAction()
    {
        $repository = $this->getDoctrine()->getRepository('Commande.php');
        
        $commandes = $repository->findAll();
        
        return $this->render('@General/Default/commandesList.html.twig', array('commandes'=> $commandes));
    }
    
    public function editAction(Request $request, Commande $commande)
    {
         //on récupère le formulaire
        $form = $this->createForm(commandesType::class, $commande);
        
        //requête lors de l'envoi du formulaire
        $form->handleRequest($request);
        
        //si le formulaire a été soumis
        if($form->isSubmitted() && $form->isValid())
        {
            //on enregistre la commande en bdd
            $em = $this->getDoctrine()->getManager();

            //envoi vers la bdd
            $em->flush();
            
            return new Response('Commande modifiée !');
        }
        
        //on génère le html du formulaire
        $formView = $form->createView();
        
        //on rend la vue
        return $this->render('@General/Default/commandes.html.twig', array ('form' => $formView));
    }
    
    public function deleteAction(Commande $commande)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($commande);
        $em->flush();
        
        return new Response('Commande supprimée');
    }
    
}
