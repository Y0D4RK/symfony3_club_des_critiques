<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sharing
 *
 * @ORM\Table(name="sharing")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SharingRepository")
 */
class Sharing
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
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", cascade={"persist"}, fetch="EAGER")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Artwork", cascade={"persist"}, fetch="EAGER")
     */
    private $artwork;

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
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Sharing
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set artwork
     *
     * @param \AppBundle\Entity\Artwork $artwork
     *
     * @return Sharing
     */
    public function setArtwork(\AppBundle\Entity\Artwork $artwork = null)
    {
        $this->artwork = $artwork;

        return $this;
    }

    /**
     * Get artwork
     *
     * @return \AppBundle\Entity\Artwork
     */
    public function getArtwork()
    {
        return $this->artwork;
    }
}
