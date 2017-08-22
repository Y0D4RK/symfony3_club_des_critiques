<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use FOS\UserBundle\Model\User as BaseUser;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 *
 * @Vich\Uploadable
 */
class User extends BaseUser
{

    /**
     * @Assert\Image(
     *     maxSize="30000000",
     *     mimeTypes={"image/png", "image/jpeg", "image/jpg"}
     * )
     * @Vich\UploadableField(mapping="avatar_image", fileNameProperty="avatarName")
     *
     * @var File
     */
    protected $avatar;

    /**
     *
     * @ORM\Column(name="avatarName", type="string", length=255, nullable=true)
     *
     * @var string
     */
    protected $avatarName;

    /**
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     *
     * @var string
     */
    protected $description;

    /**
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     *
     * @var string
     */
    protected $lastname;

    /**
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     *
     * @var string
     */
    protected $firstname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="datetime", nullable=true)
     */
    protected $birthdate;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Artwork", mappedBy="user")
     */
    private $artworks;

    /**
     *
     * @ORM\Column(name="token_tchat", type="string", length=255, nullable=true)
     *
     * @var string
     */
    protected $tokenTchat;

    public function __toString()
    {
        return $this->username;
    }

    public function __construct()
    {
        parent::__construct();
        $this->artworks = new ArrayCollection();
    }

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
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return User
     */
    public function setAvatar(File $image = null)
    {
        $this->avatar = $image;

        if ($image) {
            $this->lastLogin = new \Datetime('now');
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set avatarName
     *
     * @param string $avatarName
     *
     * @return User
     */
    public function setAvatarName($imageName)
    {
        $this->avatarName = $imageName;

        return $this;
    }

    /**
     * Get avatarName
     *
     * @return string
     */
    public function getAvatarName()
    {
        return $this->avatarName;
    }

    /**
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param \DateTime $birthdate
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }


}
