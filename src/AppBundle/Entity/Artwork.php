<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * Artwork
 *
 * @ORM\Table(name="artwork")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArtworkRepository")
 *
 * @Vich\Uploadable
 */
class Artwork
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
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="user", type="string", length=255)
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publish_at", type="datetime")
     */
    private $publishAt;

    /**
     * @var string
     *
     * @ORM\Column(name="edithor", type="string", length=255)
     */
    private $edithor;

    /**
     * @Vich\UploadableField(mapping="cover_image", fileNameProperty="coverName")
     *
     * @var File
     */
    private $cover;

    /**
     * @var string
     *
     * @ORM\Column(name="cover_name", type="string", length=255, nullable=true)
     */
    private $coverName;

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
     * @return Artwork
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
     * Set description
     *
     * @param string $description
     *
     * @return Artwork
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Artwork
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return Artwork
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Artwork
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Artwork
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set publishAt
     *
     * @param \DateTime $publishAt
     *
     * @return Artwork
     */
    public function setPublishAt($publishAt)
    {
        $this->publishAt = $publishAt;

        return $this;
    }

    /**
     * Get publishAt
     *
     * @return \DateTime
     */
    public function getPublishAt()
    {
        return $this->publishAt;
    }

    /**
     * Set edithor
     *
     * @param string $edithor
     *
     * @return Artwork
     */
    public function setEdithor($edithor)
    {
        $this->edithor = $edithor;

        return $this;
    }

    /**
     * Get edithor
     *
     * @return string
     */
    public function getEdithor()
    {
        return $this->edithor;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Artwork
     */
    public function setCover(File $image = null)
    {
        $this->cover = $image;

        if ($image) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Set coverName
     *
     * @param string $coverName
     *
     * @return Game
     */
    public function setCoverName($imageName)
    {
        $this->coverName = $imageName;

        return $this;
    }

    /**
     * Get coverName
     *
     * @return string
     */
    public function getCoverName()
    {
        return $this->coverName;
    }
}

