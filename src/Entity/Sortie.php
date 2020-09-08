<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @ORM\Table(name="sortie")
 * @ORM\Entity(repositoryClass="App\Repository\SortieRepository")
 */
class Sortie extends AbstractController
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $SortieId;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nomSortie;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $etat;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateHeure;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateLimiteInscription;

    /**
     * @ORM\Column(type="string", length=10000, nullable=true)
     */
    private $inscrie;

    /**
     * @ORM\Column(type="string", precision=3)
     */
    private $nbplaces;

    /**
     * @ORM\Column(type="integer", precision=3)
     */
    private $duree;

    /**
     * @ORM\Column(type="text")
     */
    private $description;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Campus", inversedBy="sorties")
     * @ORM\JoinColumn(nullable=true, name="campus", referencedColumnName="campus_id")
     */
    private $campus;


    /**
     * @ORM\Column(type="string", length=100)
     */
    private $rue;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $codePostal;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="sorties")
     * @ORM\JoinColumn(nullable=true, name="organisateur", referencedColumnName="id")
     */
    private $organisateur;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $motifAnnulation;

    /**
     * @return mixed
     */
    public function getSortieId()
    {
        return $this->SortieId;
    }

    /**
     * @param mixed $SortieId
     */
    public function setSortieId($SortieId)
    {
        $this->SortieId = $SortieId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNomSortie()
    {
        return $this->nomSortie;
    }

    /**
     * @param mixed $nomSortie
     */
    public function setNomSortie($nomSortie)
    {
        $this->nomSortie = $nomSortie;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateHeure()
    {
        return $this->dateHeure;
    }

    /**
     * @param mixed $dateHeure
     */
    public function setDateHeure($dateHeure)
    {
        $this->dateHeure = $dateHeure;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateLimiteInscription()
    {
        return $this->dateLimiteInscription;
    }

    /**
     * @param mixed $dateLimiteInscription
     */
    public function setDateLimiteInscription($dateLimiteInscription)
    {
        $this->dateLimiteInscription = $dateLimiteInscription;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNbplaces()
    {
        return $this->nbplaces;
    }

    /**
     * @param mixed $nbplaces
     */
    public function setNbplaces($nbplaces)
    {
        $this->nbplaces = $nbplaces;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * @param mixed $duree
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCampus()
    {
        return $this->campus;
    }

    /**
     * @param mixed $campus
     */
    public function setCampus($campus)
    {
        $this->campus = $campus;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRue()
    {
        return $this->rue;
    }

    /**
     * @param mixed $rue
     */
    public function setRue($rue)
    {
        $this->rue = $rue;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * @param mixed $codePostal
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param mixed $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrganisateur()
    {
        return $this->organisateur;
    }

    /**
     * @param Sortie $organisateur
     */
    public function setOrganisateur(User $organisateur)
    {
        $this->organisateur = $organisateur;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInscrie()
    {
        return $this->inscrie;
    }

    /**
     * @param mixed $inscrie
     */
    public function setInscrie($inscrie)
    {
        $this->inscrie = $inscrie;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMotifAnnulation()
    {
        return $this->motifAnnulation;
    }

    /**
     * @param mixed $motifAnnulation
     */
    public function setMotifAnnulation($motifAnnulation)
    {
        $this->motifAnnulation = $motifAnnulation;
        return $this;
    }

}
