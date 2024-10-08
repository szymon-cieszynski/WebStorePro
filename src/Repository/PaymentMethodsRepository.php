<?php

namespace App\Repository;

use App\Entity\PaymentMethods;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PaymentMethods>
 *
 * @method PaymentMethods|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentMethods|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentMethods[]    findAll()
 * @method PaymentMethods[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentMethodsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentMethods::class);
    }

    public function save(PaymentMethods $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PaymentMethods $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
