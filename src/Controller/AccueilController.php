<?php


namespace App\Controller;


use App\Entity\Campus;
use App\Entity\Photo;
use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/sortir.com/", name="accueil")
     */
    public function accueil(EntityManagerInterface $em){

        ////// Vérifier date de la sortie, archivé les sorties de plus de 30 jours => Etat == Archivé,
        ///  et Etat == Fermé pour entre 30 jours et maintenant
        $sortieRepo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortiesAll=$sortieRepo->findAll();

        $campusRepo = $this->getDoctrine()->getRepository(Campus::class);
        $campus = $campusRepo->findAll();

        $date= new \DateTime("- 30 days");
        foreach ($sortiesAll as $sortie)
        {
            if ($sortie->getDateHeure()<$date and $sortie->getEtat()!="Archivée" and $sortie->getEtat()!="Annulée")
            {
                $sortie->setEtat("Archivée");
                $em->persist($sortie);
                $em->flush();

            } elseif ($date<$sortie->getDateHeure() and $sortie->getDateHeure() < new \DateTime('now') and $sortie->getEtat()!="Fermée" and $sortie->getEtat()!="Annulée")
            {
                $sortie->setEtat("Fermée");
                $em->persist($sortie);
                $em->flush();
            }

        }

    //// Variable pour manipulation du filte
        $dateDebut="";
        $dateFin = "2099-12-31";
        $organisateur="";
        $inscrit="";
        $pasInscrit="";
        $passees="";
        $organisateurCheck="";
        $inscritCheck="";
        $pasInscritCheck="";
        $passeesCheck="";
        $search="";
        $submit="";
        $tableauRecherche[]=null;

        $campu= new Campus();

        $user = $this->getUser();
        $username=$user->getUsername();



/////// GESTION DES CAMPUS ///////////
       if(isset($_POST['selectCampus']))
        {
            foreach($campus as $camp){
                if($camp->getNomCampus()==$_POST['selectCampus']){
                    $campu=$camp;
                }
            }

            $sorties = $sortieRepo->findAllByCampusDate($campu);
            $sorties2=$sorties3=$sorties4=$sorties5=$sorties;


                $selectCampus=($_POST['selectCampus']);
                $optionOther="selected=\"selected\"";
                $optionUser="";


        } else {
//////////////// Premier passage sur la page ////////////////

                $sorties = null;


           $sorties2 = $sortieRepo->findAllByDateOrganisateur($username);
           $sorties3 = $sortieRepo->findAllByDateInscrit($username, $sortiesAll);
           $sorties4 = $sortieRepo->findAllByDatePasInscrit($username, $sortiesAll);


           $organisateurCheck="checked=\"checked\"";
           $organisateur="organisateur";

           $inscritCheck="checked=\"checked\"";
           $inscrit="inscrit";

           $pasInscritCheck="checked=\"checked\"";
           $pasInscrit="pasInscrit";

            $optionOther="";
            $optionUser="selected=\"selected\"";
        }

///// GESTION DU RESTE DES FILTRES ////////

        if(isset($_POST['Rechercher'])){ // si formulaire soumis

                $submit="submit";
           ////// RECHERCHE PAR MOT CLE //////////
              if (isset($_POST['search']) and $_POST['search']!="")
              {
                  $search="search";
                  $phrase=$_POST['search'];
                    var_dump("boucle search");
                  $sortiesRepo = $this->getDoctrine()->getRepository(Sortie::class);
                  $sorties = $sortiesRepo->findAll();

                  foreach ($sorties as $sortie)
                  {
                      $motSortie=$this->extraireMotsDUnePhrase($sortie->getNomSortie());
                      foreach ($motSortie as $value)
                      {
                          if ($value == $phrase)
                          {
                              array_push($tableauRecherche, $sortie->getNomSortie());
                          }
                      }
                  }
              }
              ////// DATE DE DEBUT ET DE FIN
            if (isset($_POST['dateDebut']) and $_POST['dateDebut'] != null)
                {
                    $dateDebut=$_POST['dateDebut'];
                }
            if (isset($_POST['dateFin']) and $_POST['dateFin'] != null)
            {
                $dateFin=$_POST['dateFin'];
            }
        }
        //// GESTION DES CHECKBOX ///////


        if (isset($_POST['organisateur'])) {
            $sorties2 = $sortieRepo->findAllByDateOrganisateur($username);

            $organisateurCheck = "checked=\"checked\"";
            $organisateur = "organisateur";
        }
        if (isset($_POST['inscrit']))
        {
            $sorties3 = $sortieRepo->findAllByDateInscrit($username, $sortiesAll);

            $inscritCheck="checked=\"checked\"";
            $inscrit="inscrit";
        }
        if (isset($_POST['pasInscrit']))
        {
            $sorties4 = $sortieRepo->findAllByDatePasInscrit($username, $sortiesAll);

            $pasInscritCheck="checked=\"checked\"";
            $pasInscrit="pasInscrit";
        }
        if (isset($_POST['passees']))
        {
            $sorties5 = $sortieRepo->findAllByCampusPassees($selectCampus);
            $passeesCheck="checked=\"checked\"";
            $passees="passees";
        }



        //// Récupérer la photo profil n°1 ///
        $photoRepo = $this->getDoctrine()->getRepository(Photo::class);
        $photo = $photoRepo->find(1);

        return $this->render('sortie/accueil.html.twig', [
            "sorties"=>$sorties,"sorties2" => $sorties2, "sorties3" =>$sorties3,"sorties4"=>$sorties4 ,
            'search'=> $search ,"submit"=> $submit,
            "optionUser"=>$optionUser, "optionOther"=>$optionOther ,
            "tableauRecherche"=>$tableauRecherche ,
            "dateDebut"=>$dateDebut, "dateFin"=>$dateFin,
            "organisateur"=>$organisateur, "inscrit"=>$inscrit, "pasInscrit"=>$pasInscrit, "passees"=>$passees,
            "organisateurCheck"=>$organisateurCheck , "inscritCheck"=>$inscritCheck, "pasInscritCheck"=>$pasInscritCheck, "passeesCheck"=>$passeesCheck,
            "username"=>$username, "campus"=>$campus,
            "photo"=>$photo
        ]);
    }

    /**
     * @Route("/sortir.com/administrateur", name="administrateur");
     */
    public function administrateur()
    {

        return $this->render('Sortie/administrateur.html.twig', [
        ]);
    }

    public function extraireMotsDUnePhrase($phrase)
    {

        /* caractères que l'on va remplacer (tout ce qui sépare les mots, en fait) */
        $aremplacer = array(",",".",";",":","!","?","(",")","[","]","{","}","\"","'"
        ," ");

        /* ... on va les remplacer par un espace, il n'y aura donc plus dans $phrase
      que des mots et des espaces */

        $enremplacement = " ";

        /* on fait le remplacement (comme dit ci-avant), puis on supprime les espaces de
        // début et de fin de chaîne (trim) */
        $sansponctuation = trim(str_replace($aremplacer, $enremplacement, $phrase));

        /* on coupe la chaîne en fonction d'un séparateur, et chaque élément est une
        // valeur d'un tableau */
        $separateur = "#[ ]+#"; // 1 ou plusieurs espaces
        $mots = preg_split($separateur, $sansponctuation);

        return $mots;
    }
    /**
     * @Route("/sortir.com/sortie_administrateur", name="sortie_administrateur");
     */
    public function fakeAdministrateur()
    {

        return $this->render('Sortie/administrateur.html.twig', [
        ]);
    }
}
