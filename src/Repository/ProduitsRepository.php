<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\Produits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produits|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produits|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produits[]    findAll()
 * @method Produits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produits::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Produits $entity, bool $flush = true): void
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
    public function remove(Produits $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

// /**
//      * fonction pour filtrer la recherche d'un utilisateur dans la barre de recherche de la page produit
//      *
//      * @return Product[]
//      */
//     public function findWithSearch(Search $search)
//     {
//         // gestion de la recherche par checkbox filtre des categories
//         $query = $this
//             ->createQueryBuilder('p') // p represente la table produit (alias)
//             ->select('p'); // on selectionne les catégories
//             // ->join('p.category', 'c'); // jointure entre les categorie du produit et la table categorie
//             //si la recherche par categorie n'est pas vide et qu’un utilisateur utilise ce champ pour effectuer une recherche
//             if(!empty($search->produit)){
//                 // On reprend la requete
//                 $query = $query
//                     ->andWhere('p.id IN (:produits)') // on rajoute dans la requete les id des categories pour qu'il soit dans la liste des categories envoyé en parametre dans l'objet search  
//                     ->setParameter('produits', $search->produit); // on passe le parametre de la recherche on verifie qu’une catégorie correspond a la recherche faite par l’utilisateur dans le parametre defini
//             }

//             // gestion de la recherche par recherche textuel dans la barre de recherche
//             if(!empty($search->string)){
//                 $query = $query
//                 ->andWhere('p.nom LIKE :string') // est-ce que p.name correspond a la recherche textuel ?
//                 ->setParameter('string', "%{$search->string}%") // recherche partiel sur la recherche effectué
//                 ->setMaxResults(2);
//             }
// 		//On retourne les résultats
//             return $query->getQuery()->getResult();
//     }














    // /**
    //  * @return Produits[] Returns an array of Produits objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Produits
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
