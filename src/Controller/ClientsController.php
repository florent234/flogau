<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\ClientsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class ClientsController extends AbstractController
{
    /**
     * @Route("/bon/{id_photo}", name="bon")
     */
    public function bon($id_photo)
    {
        return $this->render('jeuxConcours/bon.html.twig',
            ["photo" => $id_photo]);
    }
    /**
     * @Route("/gagnant/{id_photo}", name="gagnant")
     */
    public function tickets($id_photo)
    {
        return $this->render('jeuxConcours/gagnant.html.twig',
            ["photo" => $id_photo]);
    }
    /**
     * @Route("/concours", name="concours")
     */
    public function accueilConcours()
    {
        return $this->render('jeuxConcours/accueil.concours.html.twig',
            []);
    }
    /**
     * @Route("/concours/bonAchats", name="bonAchats")
     */
    public function bonAchatsConcours()
    {
        return $this->render('jeuxConcours/bonAchats.html.twig',
            []);
    }
    /**
     * @Route("/clients/inscription", name="clients_inscription");
     */
    public function inscription(EntityManagerInterface $em,
                                Request $request){

        $utilisateur = new Clients();
        $utilisateur->setDateCreation(new \DateTime());

        $formInscription = $this->createForm(ClientsType::class, $utilisateur);

        $formInscription->handleRequest($request);

        if( $formInscription->isSubmitted() && $formInscription->isValid()){

            $em->persist($utilisateur);
            $em->flush();

           // return $this->redirectToRoute('home',['id'=>$utilisateur->getId(), "utilisateur"=>$utilisateur]);
            return $this->redirectToRoute('bonAchats',[]);

        }

        return $this->render('jeuxConcours/inscription.html.twig',
            ["formInscription"=>$formInscription->createView()]);
    }

    /**
     * @Route("/clients/profils", name="clients_profils")
     */
    public function listeUtilisateur(){

        $userRepo = $this->getDoctrine()->getRepository(Clients::class);
        $utilisateurs =$userRepo->findAll();


        return $this->render('User/profils.html.twig', [
            "utilisateurs"=>$utilisateurs]);
    }


    /**
     * @Route("/clients/supprimer/{id}", name="clients_profil_supprimer", requirements={"id": "\d+" });
     */
    public function supprimer($id, EntityManagerInterface $em){

        $userRepo = $this->getDoctrine()->getRepository(Clients::class);
        $utilisateur =$userRepo->find($id);

        if($utilisateur->getActif()==true){
            $this->addFlash('success', 'Attention vous souhaitez supprimer un utilisateur !! L\'utilisateur dois être désactivé avant !!');
        } else {
            $em->remove($utilisateur);
            $em->flush();
        }

        $userRepo = $this->getDoctrine()->getRepository(Clients::class);
        $utilisateurs =$userRepo->findAll();

        return $this->redirectToRoute('profils',[
            "utilisateurs"=>$utilisateurs
        ]);
    }

    /**
     * @Route("/clients/profil_afficher/{id}", name="clients_profil_afficher", requirements={"id": "\d+" })
     */
    public function afficher($id){


        $userRepo = $this->getDoctrine()->getRepository(Clients::class);
        $utilisateurs =$userRepo->findAll();

        $utilisateur = new Clients();



        return $this->render('User/profil_afficher.html.twig', [ "utilisateur"=>$utilisateur]);
    }
}
