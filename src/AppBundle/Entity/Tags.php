<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tags
 * @ORM\Table(name="tags") 
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TagsRepository") 
 */
class Tags
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
     * @var int
     *
     * @ORM\Column(name="points_id", type="integer")
     */
    private $pointsId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Points", inversedBy="tags")
     * @ORM\JoinColumn(nullable=true)
     */
    private $points;

    /**
     * @var int
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $enable = 0;

    public function getId()
    {
        return $this->id;
    }

    public function setPointsId($pointsId)
    {
        $this->pointsId = $pointsId;
        return $this;
    }
   
    public function getPointsId()
    {
        return $this->pointsId;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function getPoints(): Points
    {
        return $this->points;
    }

    public function setPoints(Points $points)
    {
        $this->points = $points;
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
}