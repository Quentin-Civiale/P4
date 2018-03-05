<?php

namespace Louvre\GeneralBundle\Controller;

use Louvre\GeneralBundle\Entity\Commandes;
use Louvre\GeneralBundle\Entity\Tickets;
use Louvre\GeneralBundle\Form\commandesType;
use Louvre\GeneralBundle\Form\ticketsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;



class RecapController extends Controller
{
    public function commandesRecapAction()
    {
        $repository = $this->getDoctrine()->getRepository('GeneralBundle:Commandes');
        
        $commandes = $repository->findAll();
        
        return $this->render('@General/Default/recapCommandes.html.twig', array('commandes'=> $commandes));
    }
    
    public function editAction(Request $request, Commandes $commande)
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
}
