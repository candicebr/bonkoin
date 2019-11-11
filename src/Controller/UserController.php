<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Form\UserType;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;



class UserController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     **/
    public function index() {

        return $this->render('index.html.twig', [
            'title' => 'hello world'
        ]);
    }

    /**
     * @Route("/user/create", name="inscription")
     */
    public function inscription(Request $request, EntityManagerInterface $em){

        $form = $this->createForm(UserType::class); // On fait passer la classe de formulaire au create form afin qu'il la génère

        $form->handleRequest($request); // On récupère le formulaire envoyé dans la requête
        if ($form->isSubmitted() && $form->isValid()) { // on véfifie si le formulaire est envoyé et si il est valide
            $article = $form->getData(); // On récupère l'article associé
            $article->setDateInscription();

            if ($em->getRepository(User::class)->findOneByPseudo($article->getPseudo()) == null) // condition le pseudo n'existe pas déjà
            {
                $em->persist($article); // on le persiste
                $em->flush(); // on save

                //initialisation de la session de l'utilisateur connecté
                $_SESSION['id'] = $article->getId();
                $_SESSION['pseudo'] = $article->getPseudo();
                $_SESSION['email'] = $article->getEmail();
                $_SESSION['dateInscription'] = $article->getDateInscription();

                return $this->redirectToRoute('homepage'); // Hop redirigé et on sort du controller
            }
            $this->addFlash('notice', 'pseudo déjà utilisé');
            return $this->render('inscription.html.twig', ['form' => $form->createView()]);
        }
        return $this->render('inscription.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/connection", name="connection")
     */
    public function connexion(Request $request, EntityManagerInterface $em)
    {
        $user = $em->getRepository(User::class)->findOneByEmail($request->get('email'));

        if(isset($_POST['email']) && $user != null)
        {
            if(isset($_POST['password']) && password_verify($request->get('password'),$user->getPassword()))
            {
                //initialisation de la session de l'utilisateur connecté
                $_SESSION['id'] = $user->getId();
                $_SESSION['pseudo'] = $user->getPseudo();
                $_SESSION['email'] = $user->getEmail();
                $_SESSION['dateInscription'] = $user->getDateInscription();

                return $this->render('profil.html.twig' , [
                    'title' => 'Profil'
                ]);
            }
            else
            {
                $this->addFlash('notice', 'mauvais mot de passe');
                return $this->render('index.html.twig', [
                    'title' => 'Connection'
                ]);            }
        }
        else
        {
            $this->addFlash('notice', "cet utilisateur n'existe pas");
            return $this->render('index.html.twig', [
                'title' => 'Connection'
            ]);
        }

    }

    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function deconnexion()
    {
        session_destroy();
        return $this->render('index.html.twig', [
            'title' => 'Connection'
        ]);
    }

    /**
     * @Route("/user/updateHandler", name="updateHandler")
     */
    public function updateHandler()
    {
        return $this->render('update_profil.html.twig', [
            'title' => 'Update'
        ]);
    }

    /**
     * @Route("/user/update", name="update")
     */
    public function update(Request $request, EntityManagerInterface $em)
    {
        //utilisateur de la session
        $user = $em->getRepository(User::class)->find($_SESSION['id']);

        if ($_POST['pseudo'] != null) //Si on modifie son pseudo
        {
            if ($em->getRepository(User::class)->findOneByPseudo($_POST['pseudo']) == null) // condition le pseudo n'existe pas déjà
            {
                $user->setPseudo($request->get('pseudo'));
                $this->addFlash('notice', 'pseudo modifié');
            }
            else
            {
                $this->addFlash('notice', 'pseudo déjà utilisé');
                return $this->render('update_profil.html.twig', [
                    'title' => 'Update'
                ]);
            }
        }
        if ($_POST['password'] != null)
        {
            $user->setPassword($request->get('password'));
            $this->addFlash('notice', 'mot de passe modifié');

        }

        //Mise à jour de la session de l'utilisateur
        $_SESSION['pseudo'] = $user->getPseudo();
        $_SESSION['password'] = $user->getPassword();

        $em->flush(); // on save

        return $this->render('profil.html.twig' , [
            'title' => 'Profil'
        ]);
    }
}