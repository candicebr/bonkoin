<?php


namespace App\Controller;


use App\Entity\Like;
use App\Entity\Advert;
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
        $repository = $em->getRepository(Advert::class);
        $advert = $repository->find($id);

        if(!$advert) {
            throw $this->createNotFoundException('Sorry, no advert');
        }

        //$repository = $em->getRepository(Like::class);
        //$liked = $repository->findOneByIds($advert, $_SESSION['user']);

        //if ($liked)
        //{
            $like = new Like();
            $like->setUser($_SESSION['user'])
                ->setAdvert($advert);

            $em->merge($like);
            $em->flush();
        //}
        //else {
         //   $em->remove($liked);
         //   $em->flush();
        //}

        return $this->redirectToRoute('advert');
    }
}