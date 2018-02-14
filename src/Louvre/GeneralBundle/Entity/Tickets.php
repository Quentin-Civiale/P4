<?php

namespace Louvre\GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Tickets
 *
 * @ORM\Table(name="tickets")
 * @ORM\Entity(repositoryClass="Louvre\GeneralBundle\Repository\TicketsRepository")
 */
class Tickets
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * 
     * @var Commandes
     *
     * @ORM\ManyToOne(targetEntity="Louvre\GeneralBundle\Entity\Commandes", inversedBy="tickets", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $commande;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=25)
     * 
     * @Assert\NotBlank(message="Veuillez renseigner votre nom")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=25)
     */
    private $prenom;

    /**
     * @var Date
     *
     * @ORM\Column(name="dateNaissance", type="date")
     *
     * @Assert\Date()
     */
    private $dateNaissance;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     *
     * @Assert\GreaterThan(value = 0, message = "Le prix doit être supèrieur à 0.")
     *
     * @Assert\NotBlank(message="Le prix est obligatoire")
     */
    private $prix;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Tickets
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Tickets
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set dateNaissance
     *
     * @param date $dateNaissance
     *
     * @return Tickets
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return date
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Tickets
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set commande
     *
     * @param \Louvre\GeneralBundle\Entity\Commandes $commande
     *
     * @return Tickets
     */
    public function setCommande(\Louvre\GeneralBundle\Entity\Commandes $commande)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return \Louvre\GeneralBundle\Entity\Commandes
     */
    public function getCommande()
    {
        return $this->commande;
    }
}
