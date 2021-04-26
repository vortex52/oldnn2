<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\User\UserInterface;
use AppBundle\Entity\Points;
use AppBundle\Entity\Image;
use AppBundle\Entity\User;
use AppBundle\Entity\Tags;
use Symfony\Component\HttpFoundation\File\File;

use AppBundle\Form\PointForm;
use AppBundle\Form\AdminPointForm;
use AppBundle\Form\AdminUserForm;

class AdminController extends Controller
{

	public function indexAction(Request $request)
    {
		return $this->render('@App/Admin/index.html.twig');
    }

    public function ClearCacheAction(Request $request)
    {
		$path = realpath($this->get('kernel')->getRootDir() . '/../bin/console');
        
        $res = exec("php " . $path . " cache:clear", $gotIt);       

        $this->addFlash('success', 'КЭШ ОЧИЩЕН');
        return $this->redirectToRoute('admin.index');
    }

    public function GetPointsAction(Request $request)
    {
        $num = $request->query->getInt('page', 1);
        $limit = 5;

        $points = $this->container->get('points.repository')->getAdminPoints($num, $limit);

        // $photos = [];
        // foreach ($points as $photo) {
        //     foreach ($photo->getImage() as $value) {
        //        $photos[] = [
        //         'src' => '/uploads/photo/'.$value->getSrc()
        //        ];
        //     }
        // }

        //$imagineCacheManager = $this->get('liip_imagine.cache.manager');

        return $this->render(
            '@App/Admin/get_user_points.html.twig', [
                'points' => $points                

        ]);
    }

    public function editPointAction(Request $request, Points $point)
    {

        $photo_obj = $point->getImage()->toArray();
       
        $photos = [];
        foreach ($photo_obj as $photo) {
            $photos[] = [
                'id' => $photo->getId(),
                'src' => '/uploads/photo/'.$photo->getSrc()
            ];
        }

        $editForm = $this->createForm(AdminPointForm::class, $point);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $point = $editForm->getData();

            $this->addAdminTags($point->getTag(), $point->getId(), $point, $point->getEnable());

            $em = $this->getDoctrine()->getManager();
            $em->persist($point);
            $em->flush();

            $this->SavePointsFile();

            $this->addFlash('success', 'Маркер обновлен, файл json объектов записан');
            return $this->redirectToRoute('admin.get.points');
            
        }

        return $this->render('@App/Admin/point_edit.html.twig', [
            'point' => $point,
            'photos' => $photos,
            'form' => $editForm->createView(),
        ]);
    }

    public function GetUsersAction(Request $request)
    {
        $num = $request->query->getInt('page', 1);
        $limit = 10;

        $users = $this->container->get('user.repository')->getAllUsers($num, $limit);

        return $this->render('@App/Admin/all_users.html.twig', [
            'users' =>  $users
        ]);
    }

    public function EditUserAction(Request $request, User $user)
    {
        $point_obj = count($user->getPoints()->toArray());        

        $editForm = $this->createForm(AdminUserForm::class, $user);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted()) {

            $user_b = $editForm->getData();           

            $em = $this->getDoctrine()->getManager();
            $em->persist($user_b);
            $em->flush();            

            $this->addFlash('success', 'Пользователь обновлен');
            return $this->redirectToRoute('admin.get.users');

        }

        return $this->render('@App/Admin/user_edit.html.twig', [
            'user' => $user,           
            'form' => $editForm->createView(),
            'photo' => $point_obj
        ]);
    }

    public function deleteUserAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        $this->addFlash('success', 'пользователь и все его маркеры удалены');
        return $this->redirectToRoute('admin.get.users');
    }

    public function SavePointsFileAction(Request $request)
    {
        $json = $this->container->get('points.repository')->getPointsJson();

        $path_to_json = realpath($this->get('kernel')->getRootDir() . '/../web/json/data_admin.json');     

        file_put_contents($path_to_json, $json);

        $this->addFlash('success', 'Файл json объектов записан');
        return $this->redirectToRoute('admin.get.points');
    }

    public function SavePointsFile()
    {
        $json = $this->container->get('points.repository')->getPointsJson();

        $path_to_json = realpath($this->get('kernel')->getRootDir() . '/../web/json/data_admin.json');     

        file_put_contents($path_to_json, $json);        
    }

    public function deletePointAction(Points $Points)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($Points);
        $em->flush();

        $this->SavePointsFile();

        $this->addFlash('success', 'Ваша точка удалена, файл json объектов записан');
        return $this->redirectToRoute('admin.get.points');
    }

    public function addAdminTags($tags, $point_id, $point, $enable)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("DELETE FROM AppBundle:Tags u WHERE u.pointsId = :point_id")->setParameter('point_id', $point_id);            
        $query->execute();

        $arr = explode(",", $tags);

        if (!empty($arr) && !empty($tags)) {
            foreach ($arr as $key => $value) {
                $tags = new Tags();
                $tags->setPointsId($point_id);
                $tags->setName($value);
                $tags->setPoints($point);
                $tags->setEnable($enable);

                $em->persist($tags);
                $em->flush();
            }
        }
    }
}
