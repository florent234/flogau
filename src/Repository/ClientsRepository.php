<?php

namespace App\Repository;

use App\Entity\Clients;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Clients|null find($id, $lockMode = null, $lockVersion = null)
 * @method Clients|null findOneBy(array $criteria, array $orderBy = null)
 * @method Clients[]    findAll()
 * @method Clients[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Clients::class);
    }


    public function findByUserMail($mailSaisie)
    {
        try {
            return $this->createQueryBuilder('u')
                ->where("u.email = :email")
                ->setParameter('email', $mailSaisie)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
        }
    }


}
