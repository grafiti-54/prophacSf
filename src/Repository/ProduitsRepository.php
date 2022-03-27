<?php

namespace App\Repository;

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

    /**
     * Requete pour récupérer les produits prioritaire à afficher sur la page d'accueil
     *
     * @param [type] $value true ou false
     * @return void
     */
    public function findByPrioritaire($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.prioritaire = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Requete permettant de récupérer des produits qui appartiennent à un département
     *
     * @param [type] $id id du département
     * 
     */
    public function findProduitByDepartement($id)
    {
        $qb = $this->createQueryBuilder('p')
            ->join('p.departement', 'd')
            ->where('d.id = :id')
            ->setParameter('id', $id)
        ;
        return $qb->getQuery()->getResult();
    }


    /**
     * Recherche les produits en fonction des mots clé 
     *
     * @return void
     */
    public function search($mots =null, $departement =null){
        $query = $this->createQueryBuilder('p');
        if($mots != null){
            $query->Where('MATCH_AGAINST(p.nom, p.description) AGAINST(:mots boolean)>0')
            ->setParameter('mots', $mots);
        }
        if($departement != null){
            $query->leftJoin('p.departement', 'd');
            $query->andWhere('d.id = :id')
                ->setParameter('id', $departement);
        }

        return $query->getQuery()->getResult();
    }






































    
// /**
//          * @var \Doctrine\ORM\QueryBuilder
//          */
//         $qb = $entitymanager->getRepository('App:Produit')
//             ->createQueryBuilder('produit'); //ceci est un Objet QueryBuilder et sur cet dernier tu peux invoquer les méthodes expr(), join() ....

//         $qb->innerJoin('App\Entity\Gamme', 'gamme', 'WITH', 'gamme.id = produit.idGamme')
//             ->andWhere( $qb->expr()->in('gamme.nom', $filtre_gamme))
//             ->innerJoin('App\Entity\PrixProduit', 'prixproduit', 'WITH', 'prixproduit.idProduit = produit.id')
//             ->andWhere($qb->expr()->gte('prixproduit.prix', $choix_prix_min))
//             ->andWhere($qb->expr()->lte('prixproduit.prix', $choix_prix_max))
//             ->andWhere( $qb->expr()->in('produit.qualite', ['1', '2']))
//             ->andWhere('produit.sculpte = \'O\'');

//         $q = $qb->orderBy('produit.dateCreation', 'desc')
//             ->getQuery();

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
//         //On retourne les résultats
//             return $query->getQuery()->getResult();
//     }





   // public function findByDepartement($id)
    // {
    //     return $this->createQueryBuilder('p')
    //     ->SELECT('p') 
    //     // ->FROM('produits')
    //     ->INNERJOIN('departement','d' )
    //     // ->ON('p.id = produits_departements.produits_id')
    //     ->WHERE('produits_departements.departements_id = :depId')
    //     ->setParameter('departementId', $id)
    //     ->orderBy('p.id', 'ASC')
    //     ->getQuery()
    //     ->getResult()
    //     ;
    // }


    // public function findByDepartement(ManagerRegistry $doctrine, int $id): ?Produits
    // {
    //     $entityManager = $this->getManager();
    //     $entitymanager = $doctrine->get->getEntityManger();
    //     $query = $entitymanager->createQuery(
    //         'SELECT p, d
    //         FROM App\Entity\Produits p
    //         INNER JOIN p.departement d
    //         WHERE d.id = :id'
    //     )->setParameter('id', $id);

    //     return $query->getOneOrNullResult();
    // }


    // public function produitParDepartement(ManagerRegistry $doctrine, int $id): ?Produits
    // {
    //     // $entityManager = $this->getManager();
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
}
