<?php


namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Advert;
use App\Form\AdvertType;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class AdvertController extends AbstractController
{
    /**
     * @Route("/adverts", name="adverts")
     */
    public function actu(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Advert::class);
        $adverts = $repository->findAllNew();

        if (!$adverts) {
            throw $this->createNotFoundException('Sorry, no advert');
        }

        return $this->render('adverts_actu.html.twig', [
            'title' => 'Adverts',
            'adverts' => $adverts
        ]);
    }

    /**
     * @Route("/advert_form", name="advert_form")
     */
    public function advertForm(Request $request, EntityManagerInterface $em)
    {

        $user = $em->getRepository(User::class)->find($_SESSION['id']);

        $form = $this->createForm(AdvertType::class);

        $form->handleRequest($request); // On récupère le formulaire envoyé dans la requête
        //if ($form->get('Categorie')->getData() == 'Voitures')
            if ($form->isSubmitted() && $form->isValid()) { // on véfifie si le formulaire est envoyé et si il est valide
                $advert = $form->getData();
                $advert->setAdvertDate();
                $advert->setAdvertUser($user);

                $em->persist($advert); // on le persiste
                $em->flush(); // on save
                return $this->redirectToRoute('advert', ['id' => $advert->getId()]); // Hop redirigé et on sort du controller

            }
        return $this->render('advert_form.html.twig', ['form' => $form->createView()]); // on envoie ensuite le formulaire au template

    }

    /**
     * @Route("/advert/{id}", name="advert")
     */
    public function showAdvert(EntityManagerInterface $em, $id)
    {
        $repository = $em->getRepository(Advert::class);
        $advert = $repository->find($id);

        if (!$advert) {
            throw $this->createNotFoundException('Sorry, no advert');
        }

        return $this->render('advert.html.twig', [
            'title' => 'Advert',
            'advert' => $advert
        ]);
    }

    /**
     * @Route("/advert/update/{id}", name="advert_update")
     */
    public function updateAdvert(Request $request, EntityManagerInterface $em, $id)
    {

        $advert = $em->getRepository(Advert::class)->find($id);

        $form = $this->createForm(AdvertType::class, $advert);

        $form->handleRequest($request); // On récupère le formulaire envoyé dans la requête
            if ($form->isSubmitted() && $form->isValid()) { // on véfifie si le formulaire est envoyé et si il est valide
                $advert = $form->getData();

                $em->persist($advert); // on le persiste
                $em->flush(); // on save
                return $this->redirectToRoute('advert', ['id' => $id]); // Hop redirigé et on sort du controller

            }
        return $this->render('advert_form.html.twig', ['form' => $form->createView()]); // on envoie ensuite le formulaire au template

    }


}