<?php

namespace Louvre\GeneralBundle\Controller;

use Louvre\GeneralBundle\Entity\Commande;
use Louvre\GeneralBundle\Entity\Ticket;
use Louvre\GeneralBundle\Form\commandeType;
use Louvre\GeneralBundle\Form\ticketType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;



class RecapController extends Controller
{
    public function commandeRecapAction()
    {
        $repository = $this->getDoctrine()->getRepository('GeneralBundle:Commande');
        
        $commandes = $repository->findAll();
        
        return $this->render('@General/Default/recapCommande.html.twig', array('commandes'=> $commandes));
    }
    
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
}
