<?php

namespace Louvre\GeneralBundle\Entity;

use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @UniqueEntity(fields={"email"}, message="Vous avez déjà un compte lié à cet email !")
 */
class User implements UserInterface
{
    const ROLE_DEFAULT = "ROLE_USER";

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $lastname;

    /**
     *
     * @Assert\NotBlank(message="Veuillez indiquez un email valide !")
     * @Assert\Email()
     * @ORM\Column(type="string", unique=true)
     */
    private $email;

    /**
     * The encoded password
     *
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */

    private $role = self::ROLE_DEFAULT;

    /**
     * A non-persisted field that's used to create the encoded password.
     *
     * @Assert\NotBlank(groups={"Registration"}, message="Veuillez renseigner un mot de passe !")
     * @var string
     */
    private $plainPassword;

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function getRoles()
    {
        return [$this->role];
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        $this->password = null;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role)
    {
        $this->role = $role;
    }

}
