<?php

namespace App\Repository;

use App\Entity\Measurment;
use App\Entity\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Measurment>
 *
 * @method Measurment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Measurment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Measurment[]    findAll()
 * @method Measurment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeasurmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Measurment::class);
    }

    public function save(Measurment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Measurment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByCity(City $city)
    {
        $qb = $this->createQueryBuilder('m');
        $qb->where('m.city = :city')
        ->setParameter('city', $city)
        ->andWhere('m.date > :now')
        ->setParameter('now', date('Y-m-d'));
        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;
    }

//    /**
//     * @return Measurment[] Returns an array of Measurment objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Measurment
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
