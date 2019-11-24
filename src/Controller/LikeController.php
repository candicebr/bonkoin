<?php


namespace App\Controller;


//use App\Entity\Like;
//use App\Entity\Advert;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class LikeController extends AbstractController
{
    /**
     * @Route("/like/{id}", name="like")
     */
    public function likeAdvert(EntityManagerInterface $em, $id) {

        $like = new Like();

        $repository = $em->getRepository(Advert::class);
        $advert = $repository->find($id);

        $repository = $em->getRepository(User::class);
        $user = $repository->find($_SESSION['id']);

        if(!$advert) {
            throw $this->createNotFoundException('Sorry, no advert');
        }

        //$repository = $em->getRepository(Like::class);
        //$liked = $repository->findOneByIds($advert, $_SESSION['user']);

        //if ($liked)
        //{

        dump($user);
        dump($advert);
        $em->persist($user);
        $em->persist($advert);
        $like->setUser($user);
        $like->setAdvert($advert);

        //$user->addLike($like);

        $em->persist($like);
        $em->flush();
        //}
        //else {
         //   $em->remove($liked);
         //   $em->flush();
        //}

        return $this->redirectToRoute('advert');
    }
}