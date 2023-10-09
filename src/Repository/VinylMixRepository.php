<?php

namespace App\Repository;

use App\Entity\VinylMix;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VinylMix>
 *
 * @method VinylMix|null find($id, $lockMode = null, $lockVersion = null)
 * @method VinylMix|null findOneBy(array $criteria, array $orderBy = null)
 * @method VinylMix[]    findAll()
 * @method VinylMix[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VinylMixRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VinylMix::class);
    }

    /**
     * @return array<VinylMix>
     */
    public function findAllOrderedByVotesFilteredByGenre(string $genre = null): array
    {
        $queryBuilder = $this->addOrderByVotesQueryBuilder();
        if ($genre !== null) {
            $queryBuilder->where('mix.genre = :genre')->setParameter('genre', $genre);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    private function addOrderByVotesQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return ($queryBuilder ?? $this->createQueryBuilder('mix'))->orderBy('mix.votes', Criteria::DESC);
    }

//    public function findOneBySomeField($value): ?VinylMix
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
