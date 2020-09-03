<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


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

}
