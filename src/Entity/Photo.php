<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhotoRepository")
 */
class Photo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $PhotoId;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nomPhoto;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codePhoto;

    /**
     * @return mixed
     */
    public function getPhotoId()
    {
        return $this->PhotoId;
    }

    /**
     * @param mixed $PhotoId
     */
    public function setPhotoId($PhotoId): void
    {
        $this->PhotoId = $PhotoId;
    }

    /**
     * @return mixed
     */
    public function getNomPhoto()
    {
        return $this->nomPhoto;
    }

    /**
     * @param mixed $nomPhoto
     */
    public function setNomPhoto($nomPhoto): void
    {
        $this->nomPhoto = $nomPhoto;
    }

    /**
     * @return mixed
     */
    public function getCodePhoto()
    {
        return $this->codePhoto;
    }

    /**
     * @param mixed $codePhoto
     */
    public function setCodePhoto($codePhoto): void
    {
        $this->codePhoto = $codePhoto;
    }


}
