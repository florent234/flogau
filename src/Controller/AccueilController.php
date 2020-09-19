<?php


namespace App\Controller;


use App\Entity\Campus;
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

        $optionOther="";
        $optionUser="";
        $search="";
        $submit="";
        $tableauRecherche[]=null;

        $selectCampus="Poitiers";

        $campu= new Campus();

        $user = $this->getUser();
        $username=$user->getUsername();
        $userId = $user->getUserId();


///// GESTION DU RESTE DES FILTRES ////////

        if(isset($_POST['Rechercher'])){ // si formulaire soumis

            $organisateur="";
            $inscrit="";
            $pasInscrit="";
            $passees="";
            $organisateurCheck="";
            $inscritCheck="";
            $pasInscritCheck="";
            $passeesCheck="";
            $optionOther="";
            $optionUser="";

            /////// GESTION DES CAMPUS ///////////
            if(isset($_POST['selectCampus']))
            {
                foreach($campus as $camp){
                    if($camp->getNomCampus()==$_POST['selectCampus']){
                        $campu=$camp;
                    }
                }

                $sorties = $sortieRepo->findAllByCampusDate($campu);

                $selectCampus=($_POST['selectCampus']);
                $optionOther="selected=\"selected\"";
                $optionUser="";

                //////////////// Premier passage sur la page ////////////////
            } else {
                $selectCampus="Poitiers";
            }
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
        if(!isset($_POST['organisateur']) and !isset($_POST['inscrit']) and !isset($_POST['pasInscrit']) and !isset($_POST['passees'])) {

            //     $sorties = $sortieRepo->findAllByCampusDate($user->getCampus());
            $sorties2 = $sortieRepo->findAllByDateOrganisateur($userId);
            $sorties3 = $sortieRepo->findAllByDateInscrit($username, $sortiesAll);
            $sorties4 = $sortieRepo->findAllByDatePasInscrit($user, $sortiesAll);
            $sorties5 = $sortieRepo->findNull($user->getCampus());

            $selectCampus="Poitiers";
            $organisateurCheck="checked=\"checked\"";
            $organisateur="organisateur";

            $inscritCheck="checked=\"checked\"";
            $inscrit="inscrit";

            $pasInscritCheck="checked=\"checked\"";
            $pasInscrit="pasInscrit";

            $optionOther="";
            $optionUser="selected=\"selected\"";
        }

        //// GESTION DES CHECKBOX ///////

        if (isset($_POST['organisateur'])) {
            $sorties2 = $sortieRepo->findAllByDateOrganisateur($userId);
            $organisateurCheck = "checked=\"checked\"";
            $organisateur = "organisateur";
        }
        if($organisateur !="organisateur"){
            $sorties2 = null;
        }

        if (isset($_POST['inscrit']))
        {
            $sorties3 = $sortieRepo->findAllByDateInscrit($username, $sortiesAll);
            $inscritCheck="checked=\"checked\"";
            $inscrit="inscrit";
        }
        if($inscrit != "inscrit"){
            $sorties3 = null;
        }

        if (isset($_POST['pasInscrit']))
        {
            $sorties4 = $sortieRepo->findAllByDatePasInscrit($user, $sortiesAll);
            $pasInscritCheck="checked=\"checked\"";
            $pasInscrit="pasInscrit";
        }
        if($pasInscrit != "pasInscrit"){
            $sorties4 = null;
        }

        if (isset($_POST['passees']))
        {
            $sorties5 = $sortieRepo->findNull($user->getCampus());
            $passeesCheck="checked=\"checked\"";
            $passees="passees";
        }
        if($passees != "passees"){
            $sorties5 = null;
        }

    //    $toutesSorties = $sorties + $sorties2 + $sorties3 + $sorties4 + $sorties5;

    //    $sortieAfficher = array_unique($toutesSorties, SORT_REGULAR);

        //// Récupérer la photo profil n°1 ///
   //     $photoRepo = $this->getDoctrine()->getRepository(Photo::class);
   //    $photo = $photoRepo->find(1);      "photo"=>$photo

        return $this->render('sortie/accueil.html.twig', [
             "sorties2" => $sorties2, "sorties3" =>$sorties3,"sorties4"=>$sorties4 , "sorties5"=>$sorties5,
            'search'=> $search ,"submit"=> $submit,
            "optionUser"=>$optionUser, "optionOther"=>$optionOther ,
            "tableauRecherche"=>$tableauRecherche ,"selectCampus"=>$selectCampus ,
            "dateDebut"=>$dateDebut, "dateFin"=>$dateFin,
            "organisateur"=>$organisateur, "inscrit"=>$inscrit, "pasInscrit"=>$pasInscrit, "passees"=>$passees,
            "organisateurCheck"=>$organisateurCheck , "inscritCheck"=>$inscritCheck, "pasInscritCheck"=>$pasInscritCheck, "passeesCheck"=>$passeesCheck,
            "username"=>$username, "campus"=>$campus,
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
