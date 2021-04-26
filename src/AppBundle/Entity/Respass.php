<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;


/**
 * Respass 
 */
class Respass
{
    /**     
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;
    
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    private $abc;

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getAbc()
    {
        return $this->abc;
    }

    public function setAbc($abc)
    {
        $this->abc = $abc;
        return $this;
    }

}