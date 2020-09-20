<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Entity\User;
use App\Form\SortieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/sortir.com/sortie")
 */
class SortieController extends AbstractController
{

    /**
     * @Route("/afficher/{id}", name="sortie_afficher", requirements={"id": "\d+" });
     */
    public function afficher($id)
    {
        ///// Récuperation de la sortie à afficher///////
        $sortieRepo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie =$sortieRepo->find($id);

        ///// Récupération des tout les utilisateurs ////
        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $utilisateurs =$userRepo->findAll();

        //// Récupérations de tout les utilisateurs inscrie a la sortie //////
        $tableauInscrie[]=null;

        foreach ($utilisateurs as $utilisateur)
        {
            $i=0;
            $phrase =$sortie->getInscrie();
            if (stripos($phrase, $utilisateur->getUsername()))
            {
                $tableauInscrie[$i]=$utilisateur;
                $i++;
            }
        }
        if(empty($sortie)){
            throw $this->createNotFoundException("La sortie n'existe pas");
        }
        return $this->render('Sortie/sortie/sortie_afficher.html.twig', [
            "sortie" => $sortie, "tableauInscrie"=>$tableauInscrie
        ]);
    }

    /**
     * @Route("/creation_sortie", name="sortie_creation");
     */
    public function creation(EntityManagerInterface $em, Request $request,UserInterface $user){

        $sortie = new Sortie();
        // L'organisateur est la personne qui crée la sortie == USER
        $sortie->setOrganisateur($user);
        /// Creation du Form SortieType
        $formSortie = $this->createForm(SortieType::class, $sortie);
        $formSortie->handleRequest($request);

        /// Cas ou le formulaire est PUBLIER
        if(isset($_POST['submit']) && $formSortie->isSubmitted() && $formSortie->isValid()){
            $sortie->setEtat("Ouverte");
            $em->persist($sortie);
            $em->flush();
            // REDIRECTION SUR ACCUEIL ////
            return $this->redirectToRoute('accueil',[]);
        }
        /// Cas ou le formulaire est ENREGISTRE
        if(isset($_POST['save']) && $formSortie->isSubmitted() && $formSortie->isValid()){
            $sortie->setEtat("En création");
            $em->persist($sortie);
            $em->flush();
            return $this->redirectToRoute('accueil',[]);
        }
        return $this->render('Sortie/sortie/sortie_creation.html.twig',
            ["formSortie"=>$formSortie->createView()]);
    }

    /**
     * @Route("/inscription_sortie/{id}", name="sortie_inscription", requirements={"id": "\d+" });
     */
    public function inscription($id, UserInterface $user, EntityManagerInterface $em)
    {
        // Récupération de la sortie concerné par l'inscription
        $sortieRepo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie =$sortieRepo->find($id);

    ///// Ajouter un utilisateur a la liste d'inscription
        $phrase =$sortie->getInscrie();
        $nvoUser="-";
        $nvoUser .=$user->getUsername();
        $phrase.=$nvoUser;
        $sortie->setInscrie($phrase);

    // Faire la mise a jour de la liste
        $em->persist($sortie);
        $em->flush();
        return $this->redirectToRoute('accueil',[]);
    }
    /**
     * @Route("/desinscription_sortie/{id}", name="sortie_desinscription", requirements={"id": "\d+" });
     */
    public function desinscription($id, Request $request, UserInterface $user, EntityManagerInterface $em)
    {
        /// Récuperation de la sortie
        $sortieRepo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie =$sortieRepo->find($id);
        ///// Retirer un utilisateur a la liste d'inscription
        $phrase =$sortie->getInscrie();
        $nvoUser="-";
        $nvoUser.=$user->getUsername();
        $phrase =  str_replace($nvoUser, "", $phrase);
        $sortie->setInscrie($phrase);
        // Faire la mise a jour de la liste
        $em->persist($sortie);
        $em->flush();
        return $this->redirectToRoute('accueil',[]);
    }
    /**
     * @Route("/sortie_modifier/{id}", name="sortie_modifier", requirements={"id": "\d+" });
     */
    public function modifier($id, EntityManagerInterface $em,
                             Request $request){

        /// Récupération de la sortie et Des Campus et Des Villes
        $sortieRepo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie =$sortieRepo->find($id);

        // Creation du formulaire //
        $formSortie = $this->createForm(SortieType::class, $sortie);
        $formSortie->handleRequest($request);
        // Cas ou la sortie est PUBLIER /////
        if(isset($_POST['submit']) && $formSortie->isSubmitted() && $formSortie->isValid()){
            $sortie->setEtat("Ouverte");
            $em->persist($sortie);
            $em->flush();

            return $this->redirectToRoute('accueil',[]);
        }
        // Cas ou la sortie est ENREGISTRE /////
        if(isset($_POST['save']) && $formSortie->isSubmitted() && $formSortie->isValid()){

          //  $sortie->setCampus($_POST['selectCampus']);
            $sortie->setEtat("En création");
            $em->persist($sortie);
            $em->flush();

            return $this->redirectToRoute('accueil',[]);
        }
        return $this->render('Sortie/sortie/sortie_modifier.html.twig', ["formSortie"=>$formSortie->createView(),"sortie"=>$sortie]);
    }


    /**
     * @Route("/sortie_publier/{id}", name="sortie_publier", requirements={"id": "\d+" });
     */
    public function publier($id, EntityManagerInterface $em){

        $sortieRepo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie =$sortieRepo->find($id);

        //modification uniquement de l'Etat et mise a jour
        $sortie->setEtat("Ouverte");
        $em->persist($sortie);
        $em->flush();
        return $this->redirectToRoute('accueil',[]);
    }

    /**
     * @Route("/sortie_annuler/{id}", name="sortie_annuler", requirements={"id": "\d+" });
     */
    public function annuler($id, EntityManagerInterface $em)
    {
        $sortieRepo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie =$sortieRepo->find($id);

        // CAS ou Annulé est validé
        /// On passe l'Etat a Annulée et on Rajouter le commentaire //////
        if(empty($sortie->getInscrie()) and isset($_POST['submit']))
        {
            $sortie->setEtat("Annulée");
            $sortie->setMotifAnnulation($_POST['commentaire']);
            $em->persist($sortie);
            $em->flush();

            return $this->redirectToRoute('accueil',[]);
        // Cas ou l'annulation est annulé on repart sur l'accueil
        } elseif (isset($_POST['reste']))
        {
            return $this->redirectToRoute('accueil',[]);
        }
        if(empty($sortie)){
            throw $this->createNotFoundException("La sortie n'existe pas");
        }

        return $this->render('Sortie/sortie/sortie_annuler.html.twig', [
            "sortie" => $sortie
        ]);
    }

}