<?php


namespace App\Controller;


use App\Entity\Campus;
use App\Form\CampusType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sortir.com/campus")
 */
class CampusController extends AbstractController
{

    /**
     * @Route("/",name="campus")
     *
     */
    public function afficherCampus(EntityManagerInterface $em,
                                   Request $request){

        $campusRepo = $this->getDoctrine()->getRepository(Campus::class);
        $campus = $campusRepo->findAll();

        $campus2= new Campus();
        $formCampus = $this->createForm(CampusType::class, $campus2);
        $formCampus->handleRequest($request);
        if(isset($_POST['submit']) && $formCampus->isSubmitted() && $formCampus->isValid())
        {
            $em->persist($campus2);
            $em->flush();

            return $this->redirectToRoute('campus',["campus"=>$campus]);
        }



        return $this->render("Sortie/campus/campus.html.twig",["campus"=>$campus, "formCampus"=>$formCampus->createView()]);
    }
    /**
     * @Route("/supprimer/{id}", name="campus_supprimer", requirements={"id": "\d+" });
     */
    public function supprimer($id, EntityManagerInterface $em,
                              Request $request){

        $campusRepo = $this->getDoctrine()->getRepository(Campus::class);
        $campusSup =$campusRepo->find($id);

        $em->remove($campusSup);
        $em->flush();

        $campusRepo = $this->getDoctrine()->getRepository(Campus::class);
        $campus = $campusRepo->findAll();

        $campus2= new Campus();
        $formCampus = $this->createForm(CampusType::class, $campus2);
        $formCampus->handleRequest($request);

        return $this->render('Sortie/campus/campus.html.twig', [
            "campus"=>$campus, "formCampus"=>$formCampus->createView()
        ]);
    }
    /**
     * @Route("/modifier/{id}", name="campus_modifier", requirements={"id": "\d+" });
     */
    public function modifier($id, EntityManagerInterface $em,
                              Request $request)
    {
        $campusRepo = $this->getDoctrine()->getRepository(Campus::class);
        $campus = $campusRepo->findAll();

        $campus2= $campusRepo->find($id);
        $formCampus = $this->createForm(CampusType::class, $campus2);
        $formCampus->handleRequest($request);
        if(isset($_POST['submit']) && $formCampus->isSubmitted() && $formCampus->isValid())
        {
            $em->persist($campus2);
            $em->flush();

            return $this->redirectToRoute('campus',["campus"=>$campus]);
        }
        return $this->render("Sortie/campus/modifier.html.twig",["campus"=>$campus, "formCampus"=>$formCampus->createView(), "id"=>$id]);
    }

}