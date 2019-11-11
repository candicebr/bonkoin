<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Advert;
use App\Form\AdvertType;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class AdvertController
{

    /**
     * @Route("/advert_form", name="advert_form")
     */
    public function advertForm(Request $request, EntityManagerInterface $em) {

        $form = $this->createForm(AdvertType::class);

        $form->handleRequest($request); // On récupère le formulaire envoyé dans la requête
        if ($form->isSubmitted() && $form->isValid()) { // on véfifie si le formulaire est envoyé et si il est valide
            $article = $form->getData(); // On récupère l'article associé
            $em->persist($article); // on le persiste
            $em->flush(); // on save
        }
        return $this->render('advert_form.html.twig', ['form' => $form->createView()]); // on envoie ensuite le formulaire au template

    }
}