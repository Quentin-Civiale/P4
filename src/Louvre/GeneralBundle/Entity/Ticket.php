<?php

namespace Louvre\GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Ticket
 *
 * @ORM\Table(name="tickets")
 * @ORM\Entity(repositoryClass="Louvre\GeneralBundle\Repository\TicketRepository")
 */
class Ticket
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
     * @var Commande
     *
     * @ORM\ManyToOne(targetEntity="Louvre\GeneralBundle\Entity\Commande", inversedBy="tickets", cascade={"persist"})
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
     * @ORM\Column(name="prix", type="decimal", precision=10, scale=2)
     *
     */
    private $prix;

    /**
     * @var bool
     *
     * @ORM\Column(name="tarifReduit", type="boolean", options={"default":false})
     *
     */
    private $tarifReduit = false;

    /**
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
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
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
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
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
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;
    }

    /**
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
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set tarifReduit
     *
     * @param bool $tarifReduit
     */
    public function setTarifReduit(bool $tarifReduit)
    {
        $this->tarifReduit = $tarifReduit;
    }

    /**
     * @return \bool
     */
    public function isTarifReduit(): bool
    {
        return $this->tarifReduit;
    }

    /**
     * Set commande
     *
     * @param \Louvre\GeneralBundle\Entity\Commande $commande
     */
    public function setCommande(\Louvre\GeneralBundle\Entity\Commande $commande)
    {
        $this->commande = $commande;
    }

    /**
     * @return \Louvre\GeneralBundle\Entity\Commande
     */
    public function getCommande()
    {
        return $this->commande;
    }
}
