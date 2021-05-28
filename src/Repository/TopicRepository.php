<?php

namespace App\Repository;

use App\Entity\Topic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Topic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Topic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Topic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TopicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Topic::class);
    }

    public function findAll()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.createdDate', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findBySection($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.section = :val')
            ->setParameter('val', $value)
            ->orderBy('t.createdDate', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
