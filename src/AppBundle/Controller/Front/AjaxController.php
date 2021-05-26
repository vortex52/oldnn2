<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Tags;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\EntityRepository;

class AjaxController extends Controller
{
	public function tagSearchAction(Request $request)
    {
        $term = $request->query->get('term');

        if (!empty($term)) {            
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery("SELECT distinct u.name FROM AppBundle:Tags u WHERE u.name LIKE '$term%' AND u.enable > 0");            
            $data = $query->getResult();

            $new_data = [];
            foreach ($data as $key => $value) {
                array_push($new_data, ['value' => $value['name']                    
                ]);
            }

            $response = new Response();
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->setContent(json_encode($new_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
            return $response;
        }
        else {
            $err = "error empty data";
            $response = new Response();
            $response->setContent($err);
            return $response;
        }
    }
}