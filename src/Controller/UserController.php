<?php


namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Form\UserType;
use App\Form\UserUpdateType;
use App\Form\UserConnectType;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



class UserController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     **/
    ///public function index() {

       /* return $this->render('connection.html.twig', [
            'title' => 'hello world'
        ]);*/

        //return $this->redirectToRoute('connection'); // Hop redirigé et on sort du controller

    //}

    private $session;

    Public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder){

        $form = $this->createForm(UserType::class); // On fait passer la classe de formulaire au create form afin qu'il la génère

        $form->handleRequest($request); // On récupère le formulaire envoyé dans la requête
        if ($form->isSubmitted() && $form->isValid()) { // on véfifie si le formulaire est envoyé et si il est valide
            $user = $form->getData(); // On récupère l'article associé
            $user->setDateInscription();

            if ($em->getRepository(User::class)->findOneByPseudo($user->getPseudo()) == null) // condition le pseudo n'existe pas déjà
            {
                //$passwordEncoded = $encoder->encodePassword($user, $user->getPassword());
                //$user->setPassword($passwordEncoded);

                $em->persist($user); // on le persiste
                $em->flush(); // on save

                //initialisation de la session de l'utilisateur connecté
                $this->session->set('id', $user->getId());
                $this->session->set('pseudo', $user->getPseudo());
                $this->session->set('email', $user->getEmail());
                $this->session->set('dateInscription', $user->getDateInscription());

                /*$_SESSION['id'] = $user->getId();
                $_SESSION['pseudo'] = $user->getPseudo();
                $_SESSION['email'] = $user->getEmail();
                $_SESSION['dateInscription'] = $user->getDateInscription();
*/
                return $this->redirectToRoute('connection'); // Hop redirigé et on sort du controller
            }
            $this->addFlash('notice', 'pseudo déjà utilisé');
            return $this->render('inscription.html.twig', ['form' => $form->createView()]);
        }
        return $this->render('inscription.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/connection", name="connection")
     */
    public function connexion(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $form = $this->createForm(UserConnectType::class); // On fait passer la classe de formulaire au create form afin qu'il la génère

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $user_info = $form->getData();
            $user = $em->getRepository(User::class)->findOneByEmail($user_info->getEmail());

            if($user)
            {
                //if ($encoder->isPasswordValid($user, $user_info->getPassword()))
                if (password_verify($form->get('password')->getData(), $user->getPassword()))
                {
                    //initialisation de la session de l'utilisateur connecté

                    $this->session->set('id', $user->getId());
                    $this->session->set('pseudo', $user->getPseudo());
                    $this->session->set('email', $user->getEmail());
                    $this->session->set('dateInscription', $user->getDateInscription());
                    /*$_SESSION['user'] = $user;
                    $_SESSION['id'] = $user->getId();
                    $_SESSION['pseudo'] = $user->getPseudo();
                    $_SESSION['email'] = $user->getEmail();
                    $_SESSION['dateInscription'] = $user->getDateInscription();*/

                    return $this->render('profil.html.twig' , [
                        'title' => 'Profil'
                    ]);
                }
                else {
                    $this->addFlash('notice', 'mauvais mot de passe');
                    return $this->render('connection.html.twig', ['title' => 'Connection', 'form' => $form->createView()]);
                }
            }
            else
            {
                $this->addFlash('notice', "cet utilisateur n'existe pas");
                return $this->render('connection.html.twig', ['title' => 'Connection', 'form' => $form->createView()]);
            }
        }
        return $this->render('connection.html.twig', ['title' => 'Connection', 'form' => $form->createView()]);
    }

    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function deconnexion()
    {
        //session_destroy();
        return $this->redirectToRoute('connection'); // Hop redirigé et on sort du controller

    }

    /**
     * @Route("/user/update", name="update")
     */
    public function update(Request $request, EntityManagerInterface $em)
    {
        $user = $em->getRepository(User::class)->find($this->session->get('id'));

        $form = $this->createForm(UserUpdateType::class);

        $form->handleRequest($request); // On récupère le formulaire envoyé dans la requête
        if ($form->isSubmitted() && $form->isValid()) { // on véfifie si le formulaire est envoyé et si il est valide
            $user_info = $form->getData();

            if ($user_info->getPseudo() != null) //Si on modifie son pseudo
            {
                if ($em->getRepository(User::class)->findOneByPseudo($user_info->getPseudo()) == null) // condition le pseudo n'existe pas déjà
                {
                    $user->setPseudo($user_info->getPseudo());
                    $this->addFlash('notice', 'pseudo modifié');
                }
                else
                {
                    $this->addFlash('notice', 'pseudo déjà utilisé');
                    return $this->render('update_profil.html.twig', ['form' => $form->createView()]);
                }
            }
            if ($user_info->getPassword() != null)
            {
                $user->setPassword($form->get('password')->getData());
                $this->addFlash('notice', 'mot de passe modifié');
            }

            //Mise à jour de la session de l'utilisateur
            $this->session->set('pseudo', $user->getPseudo());
            //$_SESSION['user'] = $user;
            //$_SESSION['pseudo'] = $user->getPseudo();

            $em->flush(); // on save
            return $this->render('profil.html.twig' , [
                'title' => 'Profil'
            ]);
        }
        return $this->render('update_profil.html.twig', ['form' => $form->createView()]);
    }
}