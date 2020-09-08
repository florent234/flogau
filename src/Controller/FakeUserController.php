<?php

namespace App\Controller;

use App\Entity\FakeUser;
use App\Entity\Photo;
use App\Entity\Sortie;
use App\Form\FakeUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;


class FakeUserController extends AbstractController
{
    /**
     * @Route("/sortir.com/inscription", name="fake_inscription");
     */
    public function inscription(EntityManagerInterface $em,
                                Request $request,
                                UserPasswordEncoderInterface $encoder){

        $utilisateur = new FakeUser();
        $utilisateur->setDateCreation(new \DateTime());

        $formInscription = $this->createForm(FakeUserType::class, $utilisateur);

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
            return $this->redirectToRoute('sortie_administrateur',[]);

        }

        return $this->render('Sortie/FakeUser/inscription.html.twig',
            ["formInscription"=>$formInscription->createView()]);
    }

    /**
     * @Route("/sortir.com/profil_modifier/{id}", name="fake_profil_modifier", requirements={"id": "\d+" })
     */
    public function modifier($id, EntityManagerInterface $em,
                             Request $request, UserInterface $user,
                             UserPasswordEncoderInterface $encoder){


        $userRepo = $this->getDoctrine()->getRepository(FakeUser::class);
        $utilisateur =$userRepo->find($id);

        $photo=null;
        $formInscription = $this->createForm(FakeUserType::class, $utilisateur);
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
                return $this->redirectToRoute('fake_profils',["photo"=>$photo]);
            }
        }

        return $this->render('Sortie/FakeUSer/profil.html.twig', ["formInscription"=>$formInscription->createView(),"photo"=>$photo ,"utilisateur"=>$user]);
    }

    /**
     * @Route("/sortir.com/profils", name="fake_profils")
     */
    public function listeUtilisateur(){

        $userRepo = $this->getDoctrine()->getRepository(FakeUser::class);
        $utilisateurs =$userRepo->findAll();

        $photoRepo = $this->getDoctrine()->getRepository(Photo::class);
        $photo = $photoRepo->find(2);

        return $this->render('Sortie/FakeUser/profils.html.twig', [
            "utilisateurs"=>$utilisateurs, "photo"=>$photo]);
    }
    /**
     * @Route("/sortir.com/bloquer/{id}", name="fake_profil_bloquer", requirements={"id": "\d+" });
     */
    public function bloquer($id, EntityManagerInterface $em){

        $userRepo = $this->getDoctrine()->getRepository(FakeUser::class);
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

        $userRepo = $this->getDoctrine()->getRepository(FakeUser::class);
        $utilisateurs =$userRepo->findAll();

        $photoRepo = $this->getDoctrine()->getRepository(Photo::class);
        $photo = $photoRepo->find(2);

        return $this->redirectToRoute('fake_profils',[
            "utilisateurs"=>$utilisateurs, "photo"=>$photo
        ]);
    }

    /**
     * @Route("/sortir.com/supprimer/{id}", name="fake_profil_supprimer", requirements={"id": "\d+" });
     */
    public function supprimer($id, EntityManagerInterface $em){

        $userRepo = $this->getDoctrine()->getRepository(FakeUser::class);
        $utilisateur =$userRepo->find($id);

        if($utilisateur->getActif()==true){
            $this->addFlash('success', 'Attention vous souhaitez supprimer un utilisateur !! L\'utilisateur dois être désactivé avant !!');
        } else {
            $em->remove($utilisateur);
            $em->flush();
        }

        $userRepo = $this->getDoctrine()->getRepository(FakeUser::class);
        $utilisateurs =$userRepo->findAll();

        $photoRepo = $this->getDoctrine()->getRepository(Photo::class);
        $photo = $photoRepo->find(2);

        return $this->redirectToRoute('fake_profils',[
            "utilisateurs"=>$utilisateurs, "photo"=>$photo
        ]);
    }


    /**
     * @Route("/sortir.com/profil_afficher/{id}", name="fake_profil_afficher", requirements={"id": "\d+" })
     */
    public function afficher($id){

        //id == id de la sortie
        $sortieRepo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie =$sortieRepo->find($id);

        $userRepo = $this->getDoctrine()->getRepository(FakeUser::class);
        $utilisateurs =$userRepo->findAll();

        $utilisateur = new FakeUser();

        foreach ($utilisateurs as $utilisateur1){
            if($utilisateur1->getUsername()==$sortie->getOrganisateur()->getUsername()){
                $utilisateur=$utilisateur1;
            }
        }
        $photo = $utilisateur->getNomPhoto();

        return $this->render('Sortie/FakeUser/profil_afficher.html.twig', ["photo"=>$photo, "utilisateur"=>$utilisateur]);
    }
}
