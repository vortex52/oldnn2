<?php

namespace AppBundle\Controller\User;

use AppBundle\Entity\Image;
use AppBundle\Entity\Points;
use AppBundle\Entity\Tags;
use AppBundle\Form\PointForm;
use AppBundle\Service\Notifier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends Controller
{
    public function indexAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $this->addFlash('warning', 'Добро пожаловать ADMIN!');
            return $this->redirectToRoute('admin.index');
        }

        return $this->render('@App/User/index.html.twig');
    }

    public function showUserPointsAction(Request $request, UserInterface $user)
    {
        $userId = $user->getId();
        $num    = $request->query->getInt('page', 1);
        $limit  = 5;

        $points = $this->container->get('points.repository')->getUserPoints($userId, $num, $limit);

        return $this->render(
            '@App/User/get_user_points.html.twig', [
                'points' => $points,
            ]);

    }

    public function showUserPointAction(Request $request, Points $points, $id)
    {
        $photo_obj = $points->getImage()->toArray();

        $photos = [];
        foreach ($photo_obj as $photo) {
            $photos[] = [
                'id'  => $photo->getId(),
                'src' => '/uploads/photo/' . $photo->getSrc(),
            ];
        }

        return $this->render(
            '@App/User/get_user_point.html.twig', [
                'points' => $points,
                'photos' => $photos,
            ]);

    }

    public function addUserPointsAction(Request $request, UserInterface $user, Notifier $notifier)
    {
        $userId    = $user->getId();
        $user_name = $user->getUsername();
        $point     = new Points();
        $image     = new Image();

        $form = $this->createForm(PointForm::class, $point);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $point = $form->getData();

            $eq_point = $this->container->get('points.repository')->findEqualPoint($point);
            $em       = $this->getDoctrine()->getManager();

            if (empty($eq_point)) {

                $point->setUserId($userId);
                $point->setUser($user);

                if (empty($point->getTag())) {
                    $point->setTag("");
                }

                $em->persist($point);
                $em->flush();

                $new_point_id = $point->getId();

                $image = $point->getImages();
                $image->setPoints($point);
                $image->setPointsId($new_point_id);

                $em->persist($image);
                $em->flush();

                $this->addTags($point->getTag(), $new_point_id, $point);

                $path = $request->getUriForPath('/admin/' . $new_point_id . '/edit_point');

                $notifier->sendAdminNotifier($path, $user_name);

                $this->addFlash('success', 'Ваш маркер записан');
                return $this->redirectToRoute('user.get.points');
            } else {

                $point_old = $this->getDoctrine()->getRepository(Points::class)->find($eq_point);

                $image = $point->getImages();
                $image->setPoints($point_old);
                $image->setPointsId($eq_point);
                $em->persist($image);
                $em->flush();

                $this->addFlash('success', 'Похожие координаты и год маркера совпадают!');
                return $this->redirectToRoute('user.get.points');
            }

        }

        return $this->render('@App/User/point_new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function addTags($tags, $point_id, $point)
    {
        $em = $this->getDoctrine()->getManager();

        $arr = explode(",", $tags);

        if (!empty($arr) && !empty($tags)) {
            foreach ($arr as $key => $value) {
                $tags = new Tags();
                $tags->setPointsId($point_id);
                $tags->setName($value);
                $tags->setPoints($point);
                $em->persist($tags);
                $em->flush();
            }
        }
    }

}
