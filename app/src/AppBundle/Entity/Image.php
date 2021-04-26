<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Image
 *
 * @ORM\Table(name="image") 
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImageRepository")
 * @Vich\Uploadable
 */
class Image
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="photo_image", fileNameProperty="src")
     * 
     * @var File
     */
    private $imageFile;

    /**
     * @var string
     *
     * @ORM\Column(name="src", type="string", length=255)
     */
    private $src;    

    /**
     * @var int
     *
     * @ORM\Column(name="points_id", type="integer")
     */
    private $pointsId;

    /**
     * @var int
     *
     * @ORM\Column(name="sort", type="integer")
     */
    private $sort;
    
    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Points", inversedBy="image")
     * @ORM\JoinColumn(nullable=true)
     */
    private $points;
    
    
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

    /**    
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $imageFile
     */
    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {            
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }
   
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }
    
    public function getSrc()
    {
        return $this->src;
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
    
    public function setSort($sort)
    {
        $this->sort = $sort;
        return $this;
    }
    
    public function getSort()
    {
        return $this->sort;
    }
    
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getPoints(): Points
    {
        return $this->points;
    }

    public function setPoints(Points $points)
    {
        $this->points = $points;
    }

}