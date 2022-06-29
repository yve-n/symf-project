<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function add(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**return products[] */
//     public function findProductsOfcategory( Category $category , int $id): array
//    {
//        return $this->createQueryBuilder('p')
//            ->Where('p.category = :val')
//            ->andWhere('p.id != :id')
//            ->setParameter('val', $category)
//            ->setParameter('id' , $id)
//             ->setMaxResults(1)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
   /** autre manière de faire
    *public function findProductsOfcategory( Product $product): array
    *{
    *    return $this->createQueryBuilder('p')
    *        ->Where('p.category = :category')
    *        ->andWhere('p.id != :id')
    *        ->setParameter('category', $product->getCategory())
    *        ->setParameter('id' , $product->getId())
    *       ->orderBy('p.id', 'ASC')
    *         ->setMaxResults(1)
    *        ->getQuery()
    *        ->getResult()
    *    ;
    *  }
    * 
    */ /**utilisation de DQL */
   public function findProductsWithSameCategory(Category $category , int $id) : array
   {
    $entityManager = $this->getEntityManager();
    $query = $entityManager->createQuery(
        'SELECT p 
        FROM App\Entity\Product p
        WHERE p.category = :category
        AND p.id != :id
        ORDER BY p.id ASC'
    )->setParameter('category', $category)
     ->setParameter('id', $id)
     ->setMaxResults(2);
    return $query->getResult();
   }

   public function getLastProducts(int $limit) : array
   {
    return $this->createQueryBuilder('p')
      ->orderBy('p.createdAt', 'DESC')
      ->setMaxResults($limit)
      ->getQuery()
      ->getResult()
    ;
   }



/**utilisation de sql */
//    public function findProductsInSameCategory(Product $product)
//    {
//     $conn = $this->getEntityManager()->getConnection();
//     $sql = 'SELECT * from product p
//     WHERE p.category_id = :categoryId 
//     AND p.id = :productId
//     ORDER BY p.id ASC LIMIT 2';
    
//     $stmt = $conn->prepare($sql);
//     $result = $stmt->executeQuery([
//         'categoryId' => $product->getCategory()->getId(),
//         'productId'  => $product->getId()
//     ]);
//     return $result->fetchAllAssociative();
//    }



//    /**
//     * @return Product[] Returns an array of Product objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
