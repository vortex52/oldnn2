<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Knp\Component\Pager\Paginator;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Symfony\Component\Ldap\Adapter\ExtLdap\Query;


class PointsRepository extends \Doctrine\ORM\EntityRepository implements PaginatorAwareInterface
{
    private $folder = '/uploads/photo/';
    
    private $paginator;

    public function setPaginator(Paginator $paginator)
    {
        $this->paginator = $paginator;
    }

    public function getPointsJson()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery("SELECT u FROM AppBundle:Points u WHERE u.enable > 0");
        $points = $query->getArrayResult();

        $arr = $this->createArrayForObject($points);

        $json = json_encode($arr, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        
        return $json;
    }

    public function getUserPoints($id, $num, $limit = 10)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery("SELECT u FROM AppBundle:Points u WHERE u.userId = $id AND u.enable > 0 ORDER BY u.id DESC");
        return $this->paginator->paginate($query, $num, $limit);     
    }

    public function getAdminPoints($num, $limit = 10)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery("SELECT u FROM AppBundle:Points u ORDER BY u.id DESC");      
        return $this->paginator->paginate($query, $num, $limit);
    }

    public function findEqualPoint($point)
    {
        $lat = $point->getLatitude();
        $long = $point->getLongitude();
        $year = $point->getYear();       

        $em = $this->getEntityManager();
        $query = $em->createQuery("SELECT u.id FROM AppBundle:Points u WHERE u.latitude = '$lat' AND u.longitude = '$long' AND u.year = '$year'");
        $res = $query->getResult();

        if (empty($res)) {
            return false;
        }
        else {
            return $res[0]['id'];
        }                
    }

    private function createArrayForObject($arr) 
    {
        $array_res = ['type' => 'FeatureCollection', 'features' => []];        

        foreach ($arr as $key => $value) {

            $array_res['features'][$key] = [
                'type' => 'Feature', 
                'id' => $value['id'],
                'geometry' => [
                    'type' => 'Point', 'coordinates' => [
                        $value['longitude'], $value['latitude']
                    ]
                ],
                'properties' => [
                    'hintContent' => $value['title'],
                    'rotation' => $value['rotation'],
                    'tags' => $this->getTagsArray($value['id'])
                ],
                'options' => [
                    'description' => $value['description'],
                    'year' => $value['year'],
                    'img' => $this->folder . $this->getPhotoToArray($value['id'])
                ]
            ];
        }
        
        return $array_res;
    }

    private function getPhotoToArray($id)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery("SELECT u.src FROM AppBundle:Image u WHERE u.pointsId = $id");
        $src = $query->getResult();
        return $src[0]['src'];
    }

    private function getTagsArray($id)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery("SELECT u.name FROM AppBundle:Tags u WHERE u.pointsId = $id AND u.enable > 0");
        $res = $query->getScalarResult();
        return array_column($res, "name");        
    }

    public function getUserByEmail($email)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery("SELECT u.email FROM AppBundle:User u WHERE u.email = :email")->setParameter('email', $email);
        
        return $email = $query->getOneOrNullResult();
    }

    public function findUserOldPass($user_id, $pass)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery("SELECT u.password FROM AppBundle:User u WHERE u.password = :pass")->setParameter('pass', $pass);
        
        return $res = $query->getOneOrNullResult();        
    }

    public function getYearRange()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery("SELECT MAX(u.year) AS max_year, MIN(u.year) AS min_year FROM AppBundle:Points u WHERE u.enable > 0");
        return $res = $query->getOneOrNullResult();        
    }

}
