<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank()     
     * 
     */
    private $longitude;

    /**
     * @ORM\Column(name="latitude", type="decimal", scale=2, nullable=true)
     * @Assert\NotBlank()
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(     
     *      max = 200,    
     *      maxMessage = "Заголовок не должен быть более {{ limit }} символов"
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank()
     * @Assert\Length(     
     *      max = 1000,    
     *      maxMessage = "Описание не должно быть более {{ limit }} символов"
     * )
     */
    private $description;    

    /**
     * @var int
     *
     * @ORM\Column(name="year", type="integer")
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 1830,
     *      max = 2000,
     *      minMessage = "Год не может быть ранее {{ limit }}",
     *      maxMessage = "Год не может быть более {{ limit }}"
     * )
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="tag", type="string", length=255, nullable=true, options = {"default": 0})
     */
    private $tag;

    /**
     * @var int
     *
     * @ORM\Column(name="rotation", type="integer")
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 0,
     *      max = 360,
     *      minMessage = "Угол сьемки не может быть менее {{ limit }}",
     *      maxMessage = "Угол сьемки не может быть более {{ limit }}"
     * )
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
     * @ORM\OneToMany(targetEntity="Image", mappedBy="points", orphanRemoval=true, cascade={"persist"}, fetch="EAGER")
     */
    private $image;
   
    private $images;

     /**
     * @ORM\OneToMany(targetEntity="Tags", mappedBy="points", orphanRemoval=true, cascade={"persist"}, fetch="EAGER")
     */
    private $tags;

    /**
     * @var int
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $enable = 0;


    public function __construct()
    {
        $this->image = new ArrayCollection();
        $this->tags = new ArrayCollection();
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

    public function getImages()
    {
        return $this->images;
    }

    public function setImages($images)
    {
        $this->images = $images;
    }

    public function getImage(): Collection
    {
        return $this->image;
    }

    public function setImage(Collection $image)
    {
        $this->image = $image;
    }

    public function setEnable($enable)
    {
        $this->enable = $enable;
        return $this;
    }
    
    public function getEnable()
    {
        return $this->enable;
    }

    public function setTags(Collection $tags)
    {
        $this->tags = $tags;
        return $this;
    }
    
    public function getTags(): Collection
    {
        return $this->tags;
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

}