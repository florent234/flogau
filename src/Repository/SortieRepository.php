<?php

namespace App\Repository;

use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;


/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    ////// Modifier la fonction findAll pour la récupérer ordonné par la variable dateHeure////////
    public function findAll()
    {
        $qb = $this->createQueryBuilder('s');
        $qb->OrderBy('s.dateHeure');
        $query=$qb->getQuery();
        return new Paginator($query);
    }

    ///// Fonction pour récupérer les sorties en fonction de leurs CAMPUS
    ///  ET OUVERTE ////////
    public function findAllByCampusDate($campus)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('s')
            ->from('App\Entity\Sortie', 's')
            ->where('s.dateHeure > :datecourant')
            ->andWhere('s.campus = :campus')
            ->setParameter('datecourant', new \DateTime('now') )
            ->setParameter('campus', $campus)
            ->orderBy('s.dateHeure', 'DESC');

        return $qb->getQuery()
            ->getResult();
    }

    ////// Récupérer Sorties en fonction de l'ORGANISATEUR ////
    ///  Et OUVERTE //////
    public function findAllByDateOrganisateur($userID)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('s')
            ->from('App\Entity\Sortie', 's')
            ->where('s.dateHeure > :datecourant')
            ->andWhere('s.organisateur = :organisateur')
            ->setParameter('datecourant', new \DateTime('now') )
            ->setParameter('organisateur', $userID)
            ->orderBy('s.dateHeure', 'DESC');

            return $qb->getQuery()
                ->getResult();
    }

    ////// Récupérer Sorties en OU je suis INSCRI //////////
    public function findAllByDateInscrit($username, $sorties)
    {
        $array[]=null;
        foreach ($sorties as $sortie)
        {
            if (strpos($sortie->getInscrie(), $username)){
                array_push($array, $sortie->getNomSortie());
            }
        }
        $qb = $this->_em->createQueryBuilder();
        $qb->select('s')
            ->from('App\Entity\Sortie', 's')
            ->where('s.dateHeure > :datecourant')
            ->andWhere('s.nomSortie IN (:array)')
            ->setParameter('datecourant', new \DateTime('now') )
            ->setParameter('array',  $array )
            ->orderBy('s.dateHeure', 'DESC');
        return $qb->getQuery()
            ->getResult();
    }


    ////// Sorties OU je NE suis PAS INSCRI ////////
    public function findAllByDatePasInscrit($user, $sorties)
    {
        $array[]=null;
        foreach ($sorties as $sortie)
        {
            if (!strpos($sortie->getInscrie(), $user->getUserName())){
                array_push($array, $sortie->getNomSortie());
            }
        }
        $qb = $this->_em->createQueryBuilder();
        $qb->select('s')
            ->from('App\Entity\Sortie', 's')
            ->where('s.dateHeure > :datecourant')
            ->andWhere('s.nomSortie IN (:array)')
            ->andWhere('s.organisateur != :organisateur')
            ->setParameter('datecourant', new \DateTime('now') )
            ->setParameter('array',  $array )
            ->setParameter('organisateur', $user->getUserId())
            ->orderBy('s.dateHeure', 'DESC');
        return $qb->getQuery()
            ->getResult();
    }
    //// Sorties en fonction du CAMPUS /// ET PASSEES /////////
    public function findAllByCampusPassees($campus)
    {
        $date = date('Y-m-d h:i:s', strtotime("-30 days"));
        $qb = $this->_em->createQueryBuilder();
        $qb->select('s')
            ->from('App\Entity\Sortie', 's')
            ->where('s.dateHeure > :datecourant')
            ->andwhere('s.dateHeure < :datejour')
            ->andWhere('s.campus = :campus')
            ->setParameter('datecourant', $date )
            ->setParameter('datejour', new \DateTime('now') )
            ->setParameter('campus', $campus)
            ->orderBy('s.dateHeure', 'DESC');
        return $qb->getQuery()
            ->getResult();
    }

    public function findNull($campus)
    {
        $date = date('Y-m-d h:i:s', strtotime("-30 days"));
        $qb = $this->_em->createQueryBuilder();
        $qb->select('s')
            ->from('App\Entity\Sortie', 's')
            ->where('s.dateHeure < :datecourant')
            ->andwhere('s.dateHeure > :datejour')
            ->andWhere('s.campus = :campus')
            ->setParameter('datecourant', $date )
            ->setParameter('datejour', new \DateTime('now') )
            ->setParameter('campus', $campus)
            ->orderBy('s.dateHeure', 'DESC');

        return $qb->getQuery()
            ->getResult();
    }
}
