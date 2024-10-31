<?php

namespace App\Repository;

use App\Entity\Dette;
use App\Enum\StatutDette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Dette>
 */
class DetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dette::class);
    }

    public function getDetteClient(int $id, int $page, int $limit): Paginator
    {
        $query = $this->createQueryBuilder('d')
            ->andWhere('d.client = :id')
            ->setParameter('id', $id)
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->orderBy('d.id', 'ASC')
            ->getQuery();

        return new Paginator($query);
    }

    public function getDetteFiltre($type, int $id, int $page, int $limit): Paginator
    {
        if ($type == StatutDette::Solde->value) {
            $query = $this->createQueryBuilder('d')
                ->where('d.montant = d.montantVerser AND d.client = :id')
                ->setParameter('id', $id)
                ->setFirstResult(($page - 1) * $limit)
                ->setMaxResults($limit)
                ->orderBy('d.id', 'ASC')
                ->getQuery();
        } elseif ($type == StatutDette::NonSolde->value) {
            $query = $this->createQueryBuilder('d')
                ->where('d.montant != d.montantVerser AND d.client = :id')
                ->setParameter('id', $id)
                ->setFirstResult(($page - 1) * $limit)
                ->setMaxResults($limit)
                ->orderBy('d.id', 'ASC')
                ->getQuery();
        } else {
            $query = $this->createQueryBuilder('d')
                ->where('d.client = :id')
                ->setParameter('id', $id)
                ->setFirstResult(($page - 1) * $limit)
                ->setMaxResults($limit)
                ->orderBy('d.id', 'ASC')
                ->getQuery();
        }
        return new Paginator($query);
    }

    public function paginatedettes(int $page, int $limit): Paginator
    {
        $query = $this->createQueryBuilder('c')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->orderBy('c.id', 'ASC')
            ->getQuery();

        return new Paginator($query);
    }

    //    /**
    //     * @return Dette[] Returns an array of Dette objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Dette
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
