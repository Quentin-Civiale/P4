<?php

namespace Louvre\GeneralBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Booking
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="Louvre\GeneralBundle\Repository\BookingRepository")
 */
class Booking
{
    const STATUT_EN_ATTENTE_DE_PAIEMENT = 'en attente de paiement';
    const STATUT_PAIEMENT_ACCEPTE = 'paiement accepté';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Ticket
     *
     * @ORM\OneToMany(targetEntity="Louvre\GeneralBundle\Entity\Ticket", mappedBy="booking", cascade={"persist", "remove"})
     *
     * @Assert\Valid()
     */
    private $tickets;

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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     *
     * @Assert\NotBlank(message="Veuillez indiquer une date de visite")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=40)
     *
     * @Assert\NotBlank(message="Veuillez indiquer une type de visite")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=40)
     *
     * @Assert\NotBlank(message="Veuillez renseigner votre email")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=40)
     */
    private $statut;

    /**
     * @var float
     *
     * @ORM\Column(name="prixTotal", type="decimal", precision=10, scale=2)
     */
    private $prixTotal;

    /**
     * @var bool
     *
     * @Assert\NotBlank(message="Merci de confirmer que vous acceptez les conditions générales d'utilisation du service en cochant la case !")
     *
     * @ORM\Column(name="registration", type="boolean", options={"default":false})
     */
    private $registration = false;

//    /**
//     * @var User
//     *
//     * @ORM\ManyToOne(targetEntity="Louvre\GeneralBundle\Entity\User", inversedBy="booking", cascade={"persist"})
//     * @ORM\JoinColumn(nullable=false)
//     */
//    private $user;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
        $newTicket = new Ticket();
        $this->addTicket($newTicket);
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
     * Set date
     *
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set statut
     *
     * @param string $statut
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
    }

    /**
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set prixTotal
     *
     * @param float $prixTotal
     */
    public function setPrixTotal(float $prixTotal)
    {
        $this->prixTotal = $prixTotal;
    }

    /**
     * @return float
     */
    public function getPrixTotal()
    {
        return $this->prixTotal;
    }

    /**
     * Add ticket
     *
     * @param Ticket $ticket
     *
     * @return Booking
     */
    public function addTicket(Ticket $ticket)
    {
        if ($this->tickets->contains($ticket)) {
            return;
        }

        $this->tickets->add($ticket);

        $ticket->setBooking($this);
    }

    /**
     * Remove ticket
     *
     * @param \Louvre\GeneralBundle\Entity\Ticket $ticket
     */
    public function removeTicket(\Louvre\GeneralBundle\Entity\Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * Set $registration
     *
     * @param bool $registration
     */
    public function setRegistration(bool $registration)
    {
        $this->registration = $registration;
    }
    /**
     * @return \bool
     */
    public function isRegistration(): bool
    {
        return $this->registration;
    }


//    /**
//     * Set user
//     *
//     * @param \Louvre\GeneralBundle\Entity\User $user
//     */
//    public function setUser(User $user)
//    {
//        $this->user = $user;
//    }
//
//    /**
//     * @return \Louvre\GeneralBundle\Entity\User
//     */
//    public function getUser()
//    {
//        return $this->user;
//    }

    /**
     * @param ExecutionContextInterface $context
     *
     * @Assert\Callback()
     */
    public function validateVisitDate(ExecutionContextInterface $context)
    {
        $now = new \DateTime('now');
        $selectedDateHour = (int) $now->format('H');

        if (($now->diff($this->date)->days === 0) && ($selectedDateHour >= 14) && $this->type === 'journee') {
            $context->buildViolation("L'heure limite de 14h00 étant dépassée, vous ne pouvez pas réservé pour la journée, mais uniquement pour la demi-journée !")
                ->atPath('date')
                ->addViolation();
        }

    }


}
