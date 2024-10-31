<?php

namespace App\Repository;

use App\DTO\ClientSearchDTO;
use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function searchClients(ClientSearchDTO $clientSearchDTO, int $page, int $limit)
    {
        $query = $this->createQueryBuilder('c');
        if ($clientSearchDTO->getTelephone()) {
            $query->andWhere('c.telephone = :telephone')
                ->setParameter('telephone', $clientSearchDTO->getTelephone());
        }
        if ($clientSearchDTO->getUsername()) {
            $query->andWhere('c.username = :username')
                ->setParameter('username', $clientSearchDTO->getUsername());
        }
        return $query->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function paginateClients(int $page, int $limit): Paginator
    {
        $query = $this->createQueryBuilder('c')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->orderBy('c.createAt', 'DESC')
            ->getQuery();

        return new Paginator($query);
    }

    //    /**
    //     * @return Client[] Returns an array of Client objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Client
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
