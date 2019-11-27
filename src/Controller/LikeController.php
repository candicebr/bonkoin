<?php


namespace App\Controller;


use App\Entity\Like;
use App\Entity\Advert;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class LikeController extends AbstractController
{
    private $session;

    Public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/like/{id}", name="like")
     */
    public function likeAdvert(EntityManagerInterface $em, $id) {

        $like = new Like();

        $repository = $em->getRepository(Advert::class);
        $advert = $repository->find($id);

        $repository = $em->getRepository(User::class);
        $user = $repository->findOneBy(['id' => $this->session->get('id')]);

        if(!$advert) {
            throw $this->createNotFoundException('Sorry, no advert');
        }

        $repository = $em->getRepository(Like::class);
        $liked = $repository->findOneByIds($advert, $this->session->get('id'));

        if ($liked == null) {

            $like->setLikeUser($user);
            $em->persist($user);
            $like->setLikeAdvert($advert);
            $em->persist($advert);

            $em->persist($like);
            $em->flush();
            $this->addFlash('notice', 'Liked');

        }
        else
        {
            $em->remove($liked);
            $em->flush();
            $this->addFlash('notice', 'Unliked');

        }
        //$user->addLike($like);
        //$advert->addLike($like);

        return $this->redirectToRoute('profil');
    }
}