<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\Sortie;
use App\Entity\User;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;


class UserController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription");
     */
    public function inscription(EntityManagerInterface $em,
                                Request $request,
                                UserPasswordEncoderInterface $encoder){

        $utilisateur = new User();
        $utilisateur->setDateCreation(new \DateTime());

        $formInscription = $this->createForm(InscriptionType::class, $utilisateur);

        $formInscription->handleRequest($request);

        if( $formInscription->isSubmitted() && $formInscription->isValid()){

            $file = $utilisateur->getIdPhoto();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$fileName);
            $utilisateur->setIdPhoto($fileName);

            $hashed = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($hashed);

            $em->persist($utilisateur);
            $em->flush();

           // return $this->redirectToRoute('home',['id'=>$utilisateur->getId(), "utilisateur"=>$utilisateur]);
            return $this->redirectToRoute('home',[]);

        }

        return $this->render('User/inscription.html.twig',
            ["formInscription"=>$formInscription->createView()]);
    }

    /**
     * @Route("/profil_modifier/{id}", name="profil_modifier", requirements={"id": "\d+" })
     */
    public function modifier($id, EntityManagerInterface $em,
                             Request $request, UserInterface $user,
                             UserPasswordEncoderInterface $encoder){


        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $utilisateur =$userRepo->find($id);

        $photo=null;
        $formInscription = $this->createForm(InscriptionType::class, $utilisateur);
        $formInscription->handleRequest($request);

        if($formInscription->isSubmitted() && $formInscription->isValid()){

            $hashed = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($hashed);

            $em->persist($utilisateur);
            $em->flush();

            $photoRepo = $this->getDoctrine()->getRepository(Photo::class);
            $photo = $photoRepo->find(2);


            if ($utilisateur->getUsername()==$user->getUsername()){
                return $this->redirectToRoute('accueil',[]);
            } else {
                return $this->redirectToRoute('profils',["photo"=>$photo]);
            }
        }

        return $this->render('User/profil.html.twig', ["formInscription"=>$formInscription->createView(),"photo"=>$photo ,"utilisateur"=>$user]);
    }

    /**
     * @Route("/profils", name="profils")
     */
    public function listeUtilisateur(){

        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $utilisateurs =$userRepo->findAll();

        $photoRepo = $this->getDoctrine()->getRepository(Photo::class);
        $photo = $photoRepo->find(2);

        return $this->render('User/profils.html.twig', [
            "utilisateurs"=>$utilisateurs, "photo"=>$photo]);
    }
    /**
     * @Route("/bloquer/{id}", name="profil_bloquer", requirements={"id": "\d+" });
     */
    public function bloquer($id, EntityManagerInterface $em){

        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $utilisateur =$userRepo->find($id);

        if($utilisateur->getActif()==true){
            $utilisateur->setActif(false);
            $em->persist($utilisateur);
            $em->flush();
        } else {
            $utilisateur->setActif(true);
            $em->persist($utilisateur);
            $em->flush();
        }

        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $utilisateurs =$userRepo->findAll();

        $photoRepo = $this->getDoctrine()->getRepository(Photo::class);
        $photo = $photoRepo->find(2);

        return $this->redirectToRoute('profils',[
            "utilisateurs"=>$utilisateurs, "photo"=>$photo
        ]);
    }

    /**
     * @Route("/supprimer/{id}", name="profil_supprimer", requirements={"id": "\d+" });
     */
    public function supprimer($id, EntityManagerInterface $em){

        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $utilisateur =$userRepo->find($id);

        if($utilisateur->getActif()==true){
            $this->addFlash('success', 'Attention vous souhaitez supprimer un utilisateur !! L\'utilisateur dois être désactivé avant !!');
        } else {
            $em->remove($utilisateur);
            $em->flush();
        }

        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $utilisateurs =$userRepo->findAll();

        $photoRepo = $this->getDoctrine()->getRepository(Photo::class);
        $photo = $photoRepo->find(2);

        return $this->redirectToRoute('profils',[
            "utilisateurs"=>$utilisateurs, "photo"=>$photo
        ]);
    }

    /**
     * @Route("/profil_afficher/{id}", name="profil_afficher", requirements={"id": "\d+" })
     */
    public function afficher($id){

        //id == id de la sortie
        $sortieRepo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie =$sortieRepo->find($id);

        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $utilisateurs =$userRepo->findAll();

        $utilisateur = new User();

        foreach ($utilisateurs as $utilisateur1){
            if($utilisateur1->getUsername()==$sortie->getOrganisateur()->getUsername()){
                $utilisateur=$utilisateur1;
            }
        }
        $photo = $utilisateur->getNomPhoto();

        return $this->render('User/profil_afficher.html.twig', ["photo"=>$photo, "utilisateur"=>$utilisateur]);
    }
}
