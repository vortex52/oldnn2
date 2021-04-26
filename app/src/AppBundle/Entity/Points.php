<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Points
 *
 * @ORM\Table(name="points") 
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PointsRepository")
 */
class Points
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
     * @ORM\Column(name="longitude", type="decimal", scale=2, nullable=true)
     */
    private $longitude;

    /**
     * @ORM\Column(name="latitude", type="decimal", scale=2, nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;    

    /**
     * @var int
     *
     * @ORM\Column(name="year", type="integer")
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="tag", type="string", length=255)
     */
    private $tag;

    /**
     * @var int
     *
     * @ORM\Column(name="rotation", type="integer")
     */
    private $rotation;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="points")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="points")
     */
    private $image;

    public function __construct()
    {
        $this->image = new ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
   
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }
   
    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }
   
    public function getLatitude()
    {
        return $this->latitude;
    }    

    public function getYear()
    {
        return $this->year;
    }

    public function setYear($year)
    {
        $this->year = $year;
        return $this;
    }

    public function setRotation($rotation)
    {
        $this->rotation = $rotation;
        return $this;
    }
    
    public function getRotation()
    {
        return $this->rotation;
    }

    public function setTag($tag)
    {
        $this->tag = $tag;
        return $this;
    }
    
    public function getTag()
    {
        return $this->tag;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }
   
    public function getUserId()
    {
        return $this->userId;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getImage(): Image
    {
        return $this->image;
    }

    public function setImage(Image $image)
    {
        $this->image = $image;
    }

}