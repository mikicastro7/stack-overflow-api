<?php

namespace App\Repository;

use App\Entity\QuestionsStackOverflow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuestionsStackOverflow>
 *
 * @method QuestionsStackOverflow|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionsStackOverflow|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionsStackOverflow[]    findAll()
 * @method QuestionsStackOverflow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionsStackOverflowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionsStackOverflow::class);
    }

//    /**
//     * @return QuestionsStackOverflow[] Returns an array of QuestionsStackOverflow objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('q.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?QuestionsStackOverflow
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
