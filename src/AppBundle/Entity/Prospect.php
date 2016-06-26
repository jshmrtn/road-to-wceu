<?php
namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Prospect
 *
 * @ORM\Table(name="prospect")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProspectRepository")
 * @ORM\HasLifecycleCallbacks
 *
 * @UniqueEntity(fields={"email"})
 */
class Prospect
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
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     *
     * @Assert\NotBlank
     * @Assert\Length(min="3", max="255")
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     *
     * @Assert\NotBlank
     * @Assert\Length(min="3", max="255")
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     *
     * @Assert\NotBlank
     * @Assert\Email
     * @Assert\Length(max="255")
     */
    private $email;


    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * Prospect constructor.
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     */
    public function __construct($firstName, $lastName, $email)
    {
        $this->firstName = (string) $firstName;
        $this->lastName = (string) $lastName;
        $this->email = (string) $email;
        $this->setCreatedAt();
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAt()
    {
        $this->createdAt = new DateTime();
    }
}

