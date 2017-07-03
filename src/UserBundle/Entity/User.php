<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{


    /**
     * @Assert\Image(
     *     maxSize="30000000",
     *     mimeTypes={"image/png", "image/jpeg", "image/jpg"}
     * )
     * @Vich\UploadableField(mapping="user_avatar", fileNameProperty="avatarName")
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
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    public function __construct()
    {
        parent::__construct();
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



}
