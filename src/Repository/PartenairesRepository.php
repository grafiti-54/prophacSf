<?php

namespace App\Repository;

use App\Entity\Partenaires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Partenaires|null find($id, $lockMode = null, $lockVersion = null)
 * @method Partenaires|null findOneBy(array $criteria, array $orderBy = null)
 * @method Partenaires[]    findAll()
 * @method Partenaires[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartenairesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Partenaires::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Partenaires $entity, bool $flush = true): void
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
    public function remove(Partenaires $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Constructeur. Requete de récupérer des partenaires qui appartiennent à un département
     *
     * @param [type] $id id du département
     * 
     */
    public function findPartenaireByDepartement($id)
    {
        $qb = $this->createQueryBuilder('p')
            ->join('p.departement', 'd')
            ->where('d.id = :id')
            ->setParameter('id', $id)
        ;
        return $qb->getQuery()->getResult();
    }

    // SELECT * 
    // FROM `partenaires`
    // INNER JOIN `partenaires_departements`
    // ON partenaires.id = partenaires_id
    // WHERE departements_id = 4;

}
