<?php

namespace AppBundle\Repository;

//use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;

use Knp\Component\Pager\Paginator;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;


class UserRepository extends \Doctrine\ORM\EntityRepository implements PaginatorAwareInterface
{
    private $paginator;

    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }   

    public function setPaginator(Paginator $paginator)
    {
        $this->paginator = $paginator;
    }

    public function getAllUsers($num, $limit = 10)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery("SELECT u FROM AppBundle:User u");

        return $this->paginator->paginate($query, $num, $limit);
    }
}