<?php

namespace App\Repository;

use App\Entity\ShippingType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ShippingType>
 *
 * @method ShippingType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShippingType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShippingType[]    findAll()
 * @method ShippingType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShippingTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShippingType::class);
    }

    public function save(ShippingType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ShippingType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
