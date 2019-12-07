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
        $this->session = $session; //on met en place la session de l'utilisateur
    }

    /**
     * @Route("/like/{id}", name="like")
     * Mettre une annonce dans ses favoris ou l'enlever
     */
    public function likeAdvert(EntityManagerInterface $em, $id) {

        $repository = $em->getRepository(Advert::class);
        $advert = $repository->find($id); // on récupère l'annonce en fonction de l'id

        $repository = $em->getRepository(User::class);
        $user = $repository->findOneBy(['id' => $this->session->get('id')]); // on récupère l'utilisateur

        if(!$advert) {
            throw $this->createNotFoundException('Sorry, no advert');
        }

        $repository = $em->getRepository(Like::class);
        $liked = $repository->findOneByIds($advert, $this->session->get('id')); // on cherche si un like existe

        if ($liked == null) { //si il n'existe pas en le créer
            $like = new Like();
            $like->setLikeUser($user); //on set l'utilisateur
            $em->persist($user);
            $like->setLikeAdvert($advert); // on set l'annonce
            $em->persist($advert);

            $em->persist($like);
            $em->flush();
        }
        else //si il existe, on le supprime
        {
            $em->remove($liked);
            $em->flush();
        }

        return $this->redirectToRoute('advert', ['id' => $id]);
    }
}