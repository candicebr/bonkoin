<?php


namespace App\Controller;

use App\Entity\AdvertSearch;
use App\Entity\Like;
use App\Entity\User;
use App\Entity\Car;
use App\Entity\Clothe;
use App\Entity\Immovable;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Advert;
use App\Form\AdvertType;
use App\Form\AdvertSearchType;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class AdvertController extends AbstractController
{
    private $session;

    Public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/", name="adverts")
     */
    public function actu(Request $request, EntityManagerInterface $em)
    {
        $search = new AdvertSearch();
        $form = $this->createForm(AdvertSearchType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { // on véfifie si le formulaire est envoyé et si il est valide
            $search = $form->getData();
            $form = $this->createForm(AdvertSearchType::class, $search);
            $form->handleRequest($request);

            $repository = $em->getRepository(Advert::class);
            $adverts = $repository->findAllNewBySearch($search);

            $adverts_search = array();

            if ($search->getCategory()) {
                if ($search->getCategory() == "Voitures") {
                    $repository = $em->getRepository(Car::class);
                    $cars = $repository->findAllBySearch($adverts, $search);
                    foreach ($cars as $car) {
                        $adverts_search[] = $car->getCarAdvert();
                    }
                } else if ($search->getCategory() == "Vêtements") {
                    $repository = $em->getRepository(Clothe::class);
                    $clothes = $repository->findAllBySearch($adverts, $search);
                    foreach ($clothes as $clothe) {
                        $adverts_search[] = $clothe->getClotheAdvert();
                    }
                } else if ($search->getCategory() == "Ventes immobilières" || $search->getCategory() == "Locations") {
                    $repository = $em->getRepository(Immovable::class);
                    $immovables = $repository->findAllBySearch($adverts, $search);
                    foreach ($immovables as $immovable) {
                        $adverts_search[] = $immovable->getImmovableAdvert();
                    }
                }

                return $this->render('adverts_actu.html.twig', [
                    'title' => 'Adverts',
                    'adverts' => $adverts_search,
                    'form' => $form->createView()
                ]);
            }

            return $this->render('adverts_actu.html.twig', [
                'title' => 'Adverts',
                'adverts' => $adverts,
                'form' => $form->createView()
            ]);
        }
        //$adverts = $this->listAdvertsByCategory($request, $em);

        $repository = $em->getRepository(Advert::class);
        $adverts = $repository->findAllNewBySearch($search);


        return $this->render('adverts_actu.html.twig', [
            'title' => 'Adverts',
            'adverts' => $adverts,
            'form' => $form->createView()
        ]);
    }

    /*public function actu_search(Request $request, EntityManagerInterface $em, $search)
    {
        $form = $this->createForm(AdvertSearchType::class, $search);
        $form->handleRequest($request);
    }*/

    /**
     * @Route("/advert_form", name="advert_form")
     */
    public function advertForm(Request $request, EntityManagerInterface $em)
    {
        $user = $em->getRepository(User::class)->find($this->session->get('id'));

        $form = $this->createForm(AdvertType::class);

        $form->handleRequest($request); // On récupère le formulaire envoyé dans la requête
            if ($form->isSubmitted() && $form->isValid()) { // on véfifie si le formulaire est envoyé et si il est valide
                $advert = $form->getData();
                $advert->setAdvertDate();
                $advert->setAdvertUser($user);

                $em->persist($advert); // on le persiste
                $em->flush(); // on save
                return $this->redirectToRoute('advert_update', ['id' => $advert->getId()]); // Hop redirigé et on sort du controller
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

        foreach ($advert->getLikes() as $likes)
        {
            if ($likes->getLikeUser()->getId() == $this->session->get('id'))
            {    return $this->render('advert.html.twig', [
                    'title' => 'Advert',
                    'advert' => $advert,
                    'liked' => true
                ]);
            }
        }

        return $this->render('advert.html.twig', [
            'title' => 'Advert',
            'advert' => $advert,
            'liked' => false
        ]);
    }

    /**
     * @Route("/advert/update/{id}", name="advert_update")
     */
    public function updateAdvert(Request $request, EntityManagerInterface $em, $id)
    {
        $advert = $em->getRepository(Advert::class)->find($id);

        if (!$advert) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

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

    /**
     * @Route("/advert/delete/{id}", name="advert_delete")
     */
    public function deleteAdvert(Request $request, EntityManagerInterface $em, $id)
    {
        $advert = $em->getRepository(Advert::class)->find($id);

        if (!$advert) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $em->remove($advert);
        $em->flush();

        return $this->redirectToRoute('actu_user'); // Hop redirigé et on sort du controller
    }

    /**
     * @Route("/user/adverts/{id}", name="user_adverts")
     */
    public function advertsFromUser (Request $request, EntityManagerInterface $em, $id)
    {
        $adverts = $em->getRepository(Advert::class)->findByUser($id);

        return $this->render('adverts_user.html.twig', [
            'title' => 'AdvertFromUser',
            'adverts' => $adverts
        ]);
    }

    /**
     * @Route("/profil", name="profil")
     */
    public function profil (Request $request, EntityManagerInterface $em)
    {
        $adverts = $em->getRepository(Advert::class)->findByUser($this->session->get('id'));

        return $this->render('profil.html.twig', [
            'title' => 'Profil',
            'adverts' => $adverts
        ]);
    }

    /**
     * @Route("/actu_user", name ="actu_user")
     */
    public function actuUser (Request $request, EntityManagerInterface $em)
    {

        $repository = $em->getRepository(Advert::class);
        $adverts = $repository->findAllNew();

        if (!$adverts) {
            throw $this->createNotFoundException('Sorry, no advert');
        }

        return $this->redirectToRoute('adverts');
    }

    /**
     * @Route("/user/favorites", name="user_favorites")
     */
    public function favorites(Request $request, EntityManagerInterface $em)
    {
        $user = $em->getRepository(User::class)->find($this->session->get('id'));
        $adverts = array();
        foreach ( $user->getLikes() as $likes )
        {
            $adverts[] = $likes->getLikeAdvert();
        }

        return $this->render('adverts_user.html.twig', [
            'title' => 'Favorite',
            'adverts' => $adverts,
        ]);
    }

    /**
     * @Route("/api/adverts", name="api_recherche")
     */
    public function listAdvertsByCategory(Request $request, EntityManagerInterface $em)
    {
        //$search = new AdvertSearch();

        $repository = $em->getRepository(Advert::class);
        $adverts = $repository->findAllNewByRequest($request->query);

        //$adverts = $em->getRepository(Advert::class)->findBy(['advert_category' => $request->query->get('category')], ['advert_date' => 'DESC'] );
        $data = array();
        foreach ($adverts as $key => $advert){
            $data[$key]['title'] = $advert->getAdvertTitle();
            $data[$key]['price'] = $advert->getAdvertPrice();
            $data[$key]['description'] = $advert->getAdvertDescription();
            $data[$key]['date'] = $advert->getAdvertDate();
            $data[$key]['localisation'] = $advert->getAdvertLocalisation();
            $data[$key]['category'] = $advert->getAdvertCategory();
            $data[$key]['region'] = $advert->getAdvertRegion();
        }

        return new JsonResponse($data);
    }

}