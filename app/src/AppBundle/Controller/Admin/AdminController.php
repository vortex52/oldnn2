<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{

	public function indexAction(Request $request)
    {
		//$points = $this->container->get('points.repository')->getPointsJson();
		
		//dump($env);
		//die();
        return $this->render('@App/Admin/index.html.twig');
    }
}
