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
        $this->session = $session; //on met en place la session de l'utilisateur
    }

    /**
     * @Route("/", name="adverts")
     * Système de recherche avec l'actualité
     */
    public function actu(Request $request, EntityManagerInterface $em)
    {
        //on creer un formulaire de recherche
        $search = new AdvertSearch();
        $form = $this->createForm(AdvertSearchType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { // on véfifie si le formulaire est envoyé et si il est valide
            $search = $form->getData(); //on récupère les données
            $form = $this->createForm(AdvertSearchType::class, $search); //on remet le formulaire mis à jour
            $form->handleRequest($request);

            $repository = $em->getRepository(Advert::class);
            $adverts = $repository->findAllNewByRequest($request); //on récupère toutes les annonces qui correspondent à la recherche
            $adverts_search = array();

            //condition sur les catégories pour détailler les filtres en fonction
            if ($search->getCategory()) {
                if ($search->getCategory() == "Voitures" || $search->getCategory() == "Motos") {
                    $repository = $em->getRepository(Car::class);
                    $cars = $repository->findAllBySearch($adverts, $search);
                    foreach ($cars as $car) { //pour toutes les voitures qui correspondent à la recherche, on récupère l'annonce reliée
                        $adverts_search[] = $car->getCarAdvert();
                    }
                } else if ($search->getCategory() == "Vêtements" || $search->getCategory() == "Chaussures") {
                    $repository = $em->getRepository(Clothe::class);
                    $clothes = $repository->findAllBySearch($adverts, $search);
                    foreach ($clothes as $clothe) { //pour tous les vêtements ou chaussures qui correspondent à la recherche, on récupère l'annonce reliée
                        $adverts_search[] = $clothe->getClotheAdvert();
                    }
                } else if ($search->getCategory() == "Ventes immobilières" || $search->getCategory() == "Locations") {
                    $repository = $em->getRepository(Immovable::class);
                    $immovables = $repository->findAllBySearch($adverts, $search);
                    foreach ($immovables as $immovable) { //pour toutes les ventes immobiliers ou locations qui correspondent à la recherche, on récupère l'annonce reliée
                        $adverts_search[] = $immovable->getImmovableAdvert();
                    }
                }

                //affichage des annonces qui correspondent à la recherche
                return $this->render('adverts_actu.html.twig', [
                    'title' => 'Adverts',
                    'curent_menu' => 'adverts',
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

        //si il n'y a pas de recherche, on affiche les annonces les plus récentes
        $repository = $em->getRepository(Advert::class);
        $adverts = $repository->findAllNewByRequest($request);

        return $this->render('adverts_actu.html.twig', [
            'title' => 'Adverts',
            'adverts' => $adverts,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/advert_form", name="advert_form")
     * Creer une annonce
     */
    public function advertForm(Request $request, EntityManagerInterface $em)
    {
        $user = $em->getRepository(User::class)->find($this->session->get('id')); //On récupère l'utilisateur connecté = créateur de l'annonce

        $form = $this->createForm(AdvertType::class); //formulaire

        $form->handleRequest($request); // On récupère le formulaire envoyé dans la requête
            if ($form->isSubmitted() && $form->isValid()) { // on véfifie si le formulaire est envoyé et si il est valide
                $advert = $form->getData();
                $advert->setAdvertDate(); //on set la date
                $advert->setAdvertUser($user); // on set l'utilisateur

                $em->persist($advert);
                $em->flush(); // on save
                return $this->redirectToRoute('advert_update', ['id' => $advert->getId()]); // on est redirigé vers update de l'annonce pour finaliser son annonce en fonction de la catégorie
            }
        return $this->render('advert_form.html.twig', ['form' => $form->createView()]); // on envoie ensuite le formulaire au template
    }

    /**
     * @Route("/advert/{id}", name="advert")
     * Afficher les détails d'une annonce
     */
    public function showAdvert(EntityManagerInterface $em, $id)
    {
        $repository = $em->getRepository(Advert::class);
        $advert = $repository->find($id); //on recupère l'annonce en fonction de l'id

        if (!$advert) {
            throw $this->createNotFoundException('Sorry, no advert');
        }

        foreach ($advert->getLikes() as $likes) // pour tous les likes de l'annonce
        {
            if ($likes->getLikeUser()->getId() == $this->session->get('id')) // si l'utilisateur a déjà aimé on envoit true pour liked
             {    return $this->render('advert.html.twig', [
                    'title' => 'Advert',
                    'advert' => $advert,
                    'liked' => true
                ]);
            }
        }

        //si l'utilisateur n'a pas aimé on envoit false
        return $this->render('advert.html.twig', [
            'title' => 'Advert',
            'advert' => $advert,
            'liked' => false
        ]);
    }

    /**
     * @Route("/advert/update/{id}", name="advert_update")
     * Mettre à jour son annonce
     */
    public function updateAdvert(Request $request, EntityManagerInterface $em, $id)
    {
        $advert = $em->getRepository(Advert::class)->find($id); // on récupère l'annonce à l'aide de l'id

        if (!$advert) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        if ($advert->getAdvertUser()->getId()==$this->session->get('id')) //si il s'agit bien de l'annonce de l'utilisateur
        {
            $form = $this->createForm(AdvertType::class, $advert); //on creer le formulaire avec les données de l'annonce à modifier déjà remplie

            $form->handleRequest($request); // On récupère le formulaire envoyé dans la requête
            if ($form->isSubmitted() && $form->isValid()) { // on véfifie si le formulaire est envoyé et si il est valide
                $advert = $form->getData();

                $em->persist($advert); // on le persiste
                $em->flush(); // on save
                return $this->redirectToRoute('advert', ['id' => $id]); // Hop redirigé et on sort du controller

            }
            return $this->render('advert_form.html.twig', ['form' => $form->createView()]); // on envoie ensuite le formulaire au template
        }
        //sinon redirection
        return $this->redirectToRoute('advert', ['id' => $id]);
    }

    /**
     * @Route("/advert/delete/{id}", name="advert_delete")
     * Supprimer son annonce
     */
    public function deleteAdvert(Request $request, EntityManagerInterface $em, $id)
    {
        $advert = $em->getRepository(Advert::class)->find($id);

        if (!$advert) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        if ($advert->getAdvertUser()->getId()==$this->session->get('id')) //si il s'agit bien de l'annonce de l'utilisateur
        {
            $em->remove($advert);
            $em->flush();

            return $this->redirectToRoute('user_adverts', ['id' => $this->session->get('id')]); // Hop redirigé et on sort du controller
        }
        //sinon redirection
        return $this->redirectToRoute('user_adverts', ['id' => $this->session->get('id')]); // Hop redirigé et on sort du controller
    }

    /**
     * @Route("/user/adverts/{id}", name="user_adverts")
     * Les annonces d'un utilisateur en fonction de son id
     */
    public function advertsFromUser (Request $request, EntityManagerInterface $em, $id)
    {
        $adverts = $em->getRepository(Advert::class)->findByUser($id); //on récupère les annonces en fonction de l'id

        return $this->render('adverts_user.html.twig', [
            'title' => "Les annonces de l'utilisateur",
            'title2'=> 'Mes Actus',
            'adverts' => $adverts
        ]);
    }

    /**
     * @Route("/profil", name="profil")
     * Le profil contient les annonces de l'utilisateur et ses infos
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
     * @Route("/user/favorites", name="user_favorites")
     * Les favoris de l'utilisateur
     */
    public function favorites(Request $request, EntityManagerInterface $em)
    {
        $user = $em->getRepository(User::class)->find($this->session->get('id')); // on récupère l'utilisateur en fonction de l'id
        $adverts = array();
        foreach ( $user->getLikes() as $likes ) //pour tous ses favoris on récupère l'annonce
        {
            $adverts[] = $likes->getLikeAdvert();
        }

        return $this->render('adverts_user.html.twig', [
            'title' => 'Mes Favoris',
            'title2' => 'Actus',
            'adverts' => $adverts,
        ]);
    }

    /**
     * @Route("/api", name="api")
     * Explication api
     */
    public function api()
    {
        return $this->render('api.html.twig');
    }

    /**
     * @Route("/api/adverts", name="api_recherche")
     * Exemple utilisation api : /api/adverts?category=Voitures&price=1000
     */
    public function apiRecherche(Request $request, EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Advert::class);
        $adverts = $repository->findAllNewByRequest($request->query); // on récupère toutes les annonces qui correspondent à la recherche

        $json=array();

        foreach ($adverts as $key => $advert) { // pour toutes les annonces, on ajoutes les données dans un tableau JSON
            $ad = array(
                'id' => $adverts[$key]->getId(),
                'title' => $adverts[$key]->getAdvertTitle(),
                'category' => $adverts[$key]->getAdvertCategory(),
                'price' => $adverts[$key]->getAdvertPrice(),
                'date' => $adverts[$key]->getAdvertDate(),
                'localisation' => $adverts[$key]->getAdvertLocalisation(),
                'region' => $adverts[$key]->getAdvertRegion()
            );

            //En fonction de la catégorie, des informations sont ajoutées au tableau
            if($adverts[$key]->getAdvertCategory() == "Voitures" || $adverts[$key]->getAdvertCategory() == "Motos")
            {
                $ad += array(
                    'car_brand' => $adverts[$key]->getCar()->getCarBrand(),
                );
            }
            else if($adverts[$key]->getAdvertCategory() == "Ventes immobilières" || $adverts[$key]->getAdvertCategory() == "Locations")
            {
                $ad += array(
                    'immovable_type' => $adverts[$key]->getImmovable()->getImmovableType(),
                );
            }
            else if($adverts[$key]->getAdvertCategory() == "Vêtements" || $advert->getAdvertCategory() == "Chaussures")
            {
                $ad += array(
                    'clothe_type' => $adverts[$key]->getClothe()->getClotheType(),
                    'clothe_universe' => $adverts[$key]->getClothe()->getClotheUniverse()
                );
            }
            //les annonces sont ajoutées l'une après l'autre dans le tableau
            $json += array($key => $ad);
        }
        return new JsonResponse($json);
    }

    /**
     * @Route("api/adverts/{id}", name="api_details_adverts")
     * Exemple utilisation api: /api/adverts/4
     */
    public function apiDetail(Request $request, EntityManagerInterface $em, $id)
    {
        $repository = $em->getRepository(Advert::class);
        $advert = $repository->find($id); // on récupère l'annonce qui correspond à la recherche

        //on ajoutes les données dans un tableau JSON
        $json = array(
            'id' => $advert->getId(),
            'title' => $advert->getAdvertTitle(),
            'category' => $advert->getAdvertCategory(),
            'price' => $advert->getAdvertPrice(),
            'description' => $advert->getAdvertDescription(),
            'date' => $advert->getAdvertDate(),
            'localisation' => $advert->getAdvertLocalisation(),
            'region' => $advert->getAdvertRegion()
        );

        //En fonction de la catégorie, des informations sont ajoutées au tableau
        if($advert->getAdvertCategory() == "Voitures")
        {
            $json += array(
                'car_brand' => $advert->getCar()->getCarBrand(),
                'car_date' => $advert->getCar()->getCarDate(),
                'car_km' => $advert->getCar()->getCarKm(),
                'car_fuel' => $advert->getCar()->getCarFuel()
            );
        }
        else if($advert->getAdvertCategory() == "Motos")
        {
            $json += array(
                'car_brand' => $advert->getCar()->getCarBrand(),
                'car_date' => $advert->getCar()->getCarDate(),
                'car_km' => $advert->getCar()->getCarKm(),
            );
        }
        else if($advert->getAdvertCategory() == "Ventes immobilières" || $advert->getAdvertCategory() == "Locations")
        {
            $json += array(
                'immovable_type' => $advert->getImmovable()->getImmovableType(),
                'immovable_surface' => $advert->getImmovable()->getImmovableSurface(),
                'immovable_room' => $advert->getImmovable()->getImmovableRoom(),
                'immovable_energy' => $advert->getImmovable()->getImmovableEnergy()
            );
        }
        else if($advert->getAdvertCategory() == "Vêtements" || $advert->getAdvertCategory() == "Chaussures")
        {
            $json += array(
                'clothe_type' => $advert->getClothe()->getClotheType(),
                'clothe_brand' => $advert->getClothe()->getClotheBrand(),
                'clothe_color' => $advert->getClothe()->getClotheColor(),
                'clothe_state' => $advert->getClothe()->getClotheState(),
                'clothe_universe' => $advert->getClothe()->getClotheUniverse()
            );
        }
        return new JsonResponse($json);
    }

}