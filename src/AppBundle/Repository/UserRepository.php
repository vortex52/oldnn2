<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Knp\Component\Pager\Paginator;

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
        $em    = $this->getEntityManager();
        $query = $em->createQuery("SELECT u FROM AppBundle:User u");

        return $this->paginator->paginate($query, $num, $limit);
    }
}
