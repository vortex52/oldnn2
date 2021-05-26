<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Changepass
 */
class Changepass
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $oldPassword;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;
  

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
        return $this;
    }    

    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    public function setOldPassword($oldPassword)
    {
        $this->oldPassword = $oldPassword;
        return $this;
    }    

}