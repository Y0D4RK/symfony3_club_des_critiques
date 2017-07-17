<?php

namespace ChatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Room
 *
 * @ORM\Table(name="room")
 * @ORM\Entity(repositoryClass="ChatBundle\Repository\RoomRepository")
 */
class Room
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Artwork", cascade={"persist"})
     */
    private $artwork;

    /**
     *
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User", cascade={"persist"})
     */
    private $creator;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startedAt", type="datetime")
     */
    private $startedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="closedAt", type="datetime")
     */
    private $closedAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean", options={"default":true})
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="route", type="string", length=255)
     */
    private $route;

    /**
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User", cascade={"persist"})
     */
//    private $users;

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
     * Set name
     *
     * @param string $name
     *
     * @return Room
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set startedAt
     *
     * @param \DateTime $startedAt
     *
     * @return Room
     */
    public function setStartedAt($startedAt)
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    /**
     * Get startedAt
     *
     * @return \DateTime
     */
    public function getStartedAt()
    {
        return $this->startedAt;
    }

    /**
     * Set closedAt
     *
     * @param \DateTime $closedAt
     *
     * @return Room
     */
    public function setClosedAt($closedAt)
    {
        $this->closedAt = $closedAt;

        return $this;
    }

    /**
     * Get closedAt
     *
     * @return \DateTime
     */
    public function getClosedAt()
    {
        return $this->closedAt;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Room
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set route
     *
     * @param string $route
     *
     * @return Room
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set creator
     *
     * @param \UserBundle\Entity\User $creator
     *
     * @return Room
     */
    public function setCreator(\UserBundle\Entity\User $creator = null)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return \UserBundle\Entity\User
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set artwork
     *
     * @param \UserBundle\Entity\Artwork $artwork
     *
     * @return Room
     */
    public function setArtwork(\UserBundle\Entity\Artwork $artwork = null)
    {
        $this->artwork = $artwork;

        return $this;
    }

    /**
     * Get artwork
     *
     * @return \UserBundle\Entity\Artwork
     */
    public function getArtwork()
    {
        return $this->artwork;
    }
}
