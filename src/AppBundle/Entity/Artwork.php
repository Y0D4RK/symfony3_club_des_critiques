<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @var text
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="artworks")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category", inversedBy="artworks")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
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
     * @var int
     *
     * @ORM\Column(name="score", type="integer", nullable=true)
     */
    private $score;


    /**
     * @var int
     *
     * @ORM\Column(name="vote_count", type="integer", nullable=true)
     */
    private $voteCount;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Sharing", mappedBy="artwork")
     */
    protected $booksShared;


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
     * @var string
     *
     * @ORM\Column(name="cover_url", type="string", length=255, nullable=true)
     */
    private $coverUrl;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var string
     *
     * @ORM\Column(name="isbn", type="string", nullable=true)
     */
    private $isbn;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->createdAt = new \DateTime('now');
        $this->enabled = false;
        $this->score = 0;
        $this->voteCount = 0;
    }

    public function __toString()
    {
        return $this->name;
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
     * @param text $description
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
     * @return text
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
     * @return Artwork
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

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param int $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }

    /**
     * @return int
     */
    public function getVoteCount()
    {
        return $this->voteCount;
    }

    /**
     * @param int $voteCount
     */
    public function setVoteCount($voteCount)
    {
        $this->voteCount = $voteCount;
    }

    /**
     * @return string
     */
    public function getCoverUrl()
    {
        return $this->coverUrl;
    }

    /**
     * @param string $coverUrl
     */
    public function setCoverUrl($coverUrl)
    {
        $this->coverUrl = $coverUrl;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * {@inheritdoc}
     */
    public function setEnabled($boolean)
    {
        $this->enabled = (bool) $boolean;

        return $this;
    }


    public function getIsbn()
    {
        return $this->isbn;
    }
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;
    }

}
