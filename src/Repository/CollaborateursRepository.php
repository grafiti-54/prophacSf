<?php

namespace App\Repository;

use App\Entity\Collaborateurs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method Collaborateurs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Collaborateurs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collaborateurs[]    findAll()
 * @method Collaborateurs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollaborateursRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Collaborateurs::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Collaborateurs $entity, bool $flush = true): void
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
    public function remove(Collaborateurs $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $collaborateurs, string $newHashedPassword): void
    {
        if (!$collaborateurs instanceof Collaborateurs) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($collaborateurs)));
        }

        $collaborateurs->setPassword($newHashedPassword);
        $this->_em->persist($collaborateurs);
        $this->_em->flush();
    }


    // Recherche des collaborateurs par nom / prenom pour futur recherche dans la liste de collaborateurs pour l'admin
    public function findCollaborateurByName(string $query)
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->orX(
                        $qb->expr()->like('c.nom', ':query'),
                        $qb->expr()->like('c.prenom', ':query'),
                    ),
                    $qb->expr()->isNotNull('c.nom')
                )
            )
            ->setParameter('query', '%' . $query . '%')
        ;
        return $qb
            ->getQuery()
            ->getResult();
    }

    /**
     * Requete permettant de récupérer les collaborateurs qui appartiennent à un département
     *
     * @param [type] $id id du département
     * @return void
     */
    public function findCollaborateurByDepartement($id)
    {
        $qb = $this->createQueryBuilder('c')
            ->join('c.departements', 'd')
            ->where('d.id = :id')
            ->setParameter('id', $id)
        ;
        return $qb->getQuery()->getResult();
    }
    //Syntaxe de la requete en SQL
    // SELECT *
    // FROM `collaborateurs` 
    // inner join `departements_collaborateurs`
    // on id = collaborateurs_id
    // where departements_id = 2;


    // /**
    //  * @return Collaborateurs[] Returns an array of Collaborateurs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
 }
