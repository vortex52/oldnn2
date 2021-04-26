<?php

namespace AppBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    
    public function indexAction(Request $request)
    {
		// $em = $this->getDoctrine()->getManager();
		// $query = $em->createQuery("SELECT u FROM AppBundle:Points u");
		// $points = $query->getResult();

		//$points = $this->container->get('points.repository')->getPointsJson();		

        return $this->render('@App/Front/HomePage/index.html.twig');
    }
}
