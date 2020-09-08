<?php

namespace App\Repository;

use App\Entity\FakeUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FakeUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method FakeUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method FakeUser[]    findAll()
 * @method FakeUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FakeuserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FakeUser::class);
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
