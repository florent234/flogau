<?php

namespace App\Entity;

use App\Repository\ClientsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @UniqueEntity(fields={"email"})
 * @ORM\Table(name="clients")
 * @ORM\Entity(repositoryClass=ClientsRepository::class)
 */
class Clients implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=10, unique=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $rgpdCentreCo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $rgpdPanel;




    /*///////////////////// GETTER AND SETTER ////////////////////*/


    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param mixed $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;

    }
    /**
     * @return mixed
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param mixed $dateCreation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getRgpdCentreCo()
    {
        return $this->rgpdCentreCo;
    }

    /**
     * @param mixed $rgpdCentreCo
     */
    public function setRgpdCentreCo($rgpdCentreCo)
    {
        $this->rgpdCentreCo = $rgpdCentreCo;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getRgpdPanel()
    {
        return $this->rgpdPanel;
    }

    /**
     * @param mixed $rgpdPanel
     */
    public function setRgpdPanel($rgpdPanel)
    {
        $this->rgpdPanel = $rgpdPanel;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }
    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getRoles()
    {
        // TODO: Implement getRoles() method.
    }

    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

}
