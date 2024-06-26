<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getProductsByFilters(array $filters): array
    {
        $queryBuilder = $this->createQueryBuilder('p');

        $queryBuilder->select('p');

        $i = 0;
        foreach ($filters as $name => $value) {
            $queryBuilder->innerJoin('p.attributes', 'a' . $i)
                ->andWhere('a' . $i . '.name = :name' . $i . ' AND a' . $i . '.value = :value' . $i)
                ->setParameter('name' . $i, $name)
                ->setParameter('value' . $i, $value[0]);
            $i++;
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
