<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Role\Role;
//use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Table(name="user")
 * @UniqueEntity(fields="email", message="Email уже занят")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */

class User implements AdvancedUserInterface
{
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;    

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $username;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    private $abc;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="Points", mappedBy="user" ,orphanRemoval=true, cascade={"persist"}, fetch="EAGER")
     */
    private $points;

    /**
     * @ORM\Column(name="is_enabled", type="boolean")
     */
    private $isEnabled;

    public function __construct()
    {
        $this->points = new ArrayCollection();
        $this->isEnabled = true;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
    	return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }   

    public function getRoles()
    {
        $roles = $this->roles;
        // give everyone ROLE_USER!
        if (!in_array('ROLE_USER', $roles)) {
            $roles[] = 'ROLE_USER';
        }
        return $roles;
    }

    public function setRole(array $roles)
    {
        $this->roles = $roles;
    }  

    public function getSalt()
    {
    	return null;
    }

    public function eraseCredentials()
    {
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

    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;
        return $this;
    }

    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isEnabled;
    }

    public function getPoints(): Collection
    {
        return $this->points;
    }

    public function setPoints(Collection $points)
    {
        $this->points = $points;
    }
}
        