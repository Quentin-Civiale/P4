<?php

namespace Louvre\GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
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
     * @var Booking
     *
     * @ORM\ManyToOne(targetEntity="Louvre\GeneralBundle\Entity\Booking", inversedBy="ticket", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $booking;

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
     *
     * @Assert\NotBlank(message="Veuillez renseigner votre prénom")
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\column(name="country", type="string", length=40)
     *
     * @Assert\NotBlank(message="Veuillez indiquer votre pays")
     */
    private $country;

    /**
     * @var Date
     *
     * @ORM\Column(name="dateNaissance", type="date")
     *
     * @Assert\Date()
     *
     * @Assert\NotBlank(message="Veuillez indiquer votre date de naissance")
     */
    private $dateNaissance;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="decimal", precision=10, scale=2)
     */
    private $prix;

    /**
     * @var bool
     *
     * @ORM\Column(name="tarifReduit", type="boolean", options={"default":false})
     */
    private $tarifReduit = false;


    private function __construct()
    {
    }

    public static function createNewTicket()
    {
        $self = new self();

        return $self;
    }

    public static function createTicket($booking, $nom, $prenom, $country, $dateNaissance, $tarifReduit)
    {
        $self = new self();
        $self->booking = $booking;
        $self->nom = $nom;
        $self->prenom = $prenom;
        $self->country = $country;
        $self->dateNaissance = $dateNaissance;
//        $self->prix = $prix;
        $self->tarifReduit = $tarifReduit;

        return $self;
    }

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
     * Set country
     *
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set dateNaissance
     *
     * @param Date $dateNaissance
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;
    }

    /**
     * @return Date
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
     * Set booking
     *
     * @param \Louvre\GeneralBundle\Entity\Booking $booking
     */
    public function setBooking(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * @return \Louvre\GeneralBundle\Entity\Booking
     */
    public function getBooking()
    {
        return $this->booking;
    }
}
