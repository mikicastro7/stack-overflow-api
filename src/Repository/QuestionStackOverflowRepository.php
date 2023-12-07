<?php

namespace App\Repository;

use App\Entity\QuestionStackOverflow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuestionStackOverflow>
 *
 * @method QuestionStackOverflow|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionStackOverflow|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionStackOverflow[]    findAll()
 * @method QuestionStackOverflow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionStackOverflowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionStackOverflow::class);
    }


    public function findQuestionsByStackOverflowIds(array $stackOverflowIds): array
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.stackOverflowId IN (:stackOverflowIds)')
            ->setParameter('stackOverflowIds', $stackOverflowIds)
            ->getQuery()
            ->getResult();
    }
}
