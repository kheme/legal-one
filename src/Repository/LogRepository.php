<?php

namespace App\Repository;

use App\Entity\Log;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Log|null find($id, $lockMode = null, $lockVersion = null)
 * @method Log|null findOneBy(array $criteria, array $orderBy = null)
 * @method Log[]    findAll()
 * @method Log[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Log::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Log $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Log $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getFilteredCount(array $filters)
    {
        $count = $this->createQueryBuilder('log')
            ->where('log.service IN (:services)')
            ->setParameter('services', $filters['services']);

        if ($filters['status']) {
            $count
                ->andWhere('log.status = :status')
                ->setParameter('status', $filters['status']);
        }

        if ($filters['start']) {
            $count
                ->andWhere('log.created_at >= :start')
                ->setParameter('start', $filters['start'] . ' 00:00:00');
        }

        if ($filters['end']) {
            $count
                ->andWhere('log.created_at <= :end')
                ->setParameter('end', $filters['end'] . ' 23:59:59');
        }
        
        return $count
            ->select('COUNT(log.id)')
            ->getQuery()
            ->getOneOrNullResult();
    }
}
