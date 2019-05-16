<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getOneChoice($id): array
    {
        $em = $this->getEntityManager();//$this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT productname FROM product WHERE idproduct = :id ORDER BY 1 LIMIT 1");
        $statement->execute(['id' => $id]);
        return   $statement->fetchAll();
    }

    public function getChoice($back = TRUE): array
    {
        $result = array((($back) ? '-- Select --' : 'Show All') => -1);
        $em = $this->getEntityManager();//$this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT idproduct, productname FROM product order by 1");
        $statement->execute();
        $res = $statement->fetchAll();
        $x=0;
        while ($x<sizeof($res)){
            //$result[$res[$x]['productname']] = $res[$x][(($back) ? 'idproduct' : 'productname')];
            $result[$res[$x]['productname']] = $res[$x]['productname'];
            $x++;
        }
        return $result;
    }
}
