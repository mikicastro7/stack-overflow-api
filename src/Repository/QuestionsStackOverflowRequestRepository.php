<?php

namespace App\Repository;

use App\Entity\QuestionsStackOverflowRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuestionsStackOverflowRequest>
 *
 * @method QuestionsStackOverflowRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionsStackOverflowRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionsStackOverflowRequest[]    findAll()
 * @method QuestionsStackOverflowRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionsStackOverflowRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionsStackOverflowRequest::class);
    }

//    /**
//     * @return QuestionsStackOverflowRequest[] Returns an array of QuestionsStackOverflowRequest objects
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

//    public function findOneBySomeField($value): ?QuestionsStackOverflowRequest
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
