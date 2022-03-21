<?php

namespace App\Repository;

use App\Entity\Departements;
use App\Entity\Produits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Departements|null find($id, $lockMode = null, $lockVersion = null)
 * @method Departements|null findOneBy(array $criteria, array $orderBy = null)
 * @method Departements[]    findAll()
 * @method Departements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Departements::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Departements $entity, bool $flush = true): void
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
    public function remove(Departements $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    // public function findArticleByDepartement($id)
    // {
    //     $qb = $this->createQueryBuilder('p')
    //         ->join('p.departement', 'd')
    //         ->where('d.id = :id')
    //         ->setParameter('id', $id)
    //     ;
    //     return $qb->getQuery()->getResult();
    // }

    // public function produitParDepartement(ManagerRegistry $doctrine,int $id): ?Produits
    // {
        
    //     $entitymanager = $doctrine->get->getEntityManger();
    //     $query = $entitymanager->createQuery(
    //         'SELECT * AS produit
    //         FROM App\Entity\Produits p 
    //         INNER JOIN App\Entity\Departements d
    //         WHERE d.id = :id'
    //     )->setParameter('id', $id);

    //     $result = $query->execute();
    //     return $result[0]['produit'];
    // }


    // public function produitParDepartement($id): ?Produits
    // {
    //     $entityManger = $this->getEntityManager();

    //     $query = $entityManger->createQuery(
    //         'SELECT d, p
    //         FROM App\Entity\Departements d
    //         INNER JOIN d.produit p
    //         WHERE d.id = :id'
    //     )->setParameter('id', $id);

    //     return $query->getOneOrNullResult();
    // }
    // /**
    //  * @return Departements[] Returns an array of Departements objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Departements
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
