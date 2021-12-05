<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

   /**
    * @return int|mixed|string return 6 post of homepage
    */
    public function findLatest()
    {
       $query = $this->QueryBuilder();
       return $query
          ->setMaxResults(6)
          ->getQuery()
          ->getResult();
    }

    public function findForSidebar()
    {
       $query = $this->QueryBuilder();
       return $query
          ->where('p.published_at <= :now')
          ->setParameter('now', new \DateTimeImmutable())
          ->setMaxResults(3)
          ->getQuery()
          ->getResult();
    }

   /**
    * @return int|mixed|string listing posts on order desc for articles page
    */
    public function findAllDesc()
    {
       $query = $this->QueryBuilder();
       return $query->getQuery()->getResult();
    }

    private function QueryBuilder(): QueryBuilder
   {
      return $this
         ->createQueryBuilder('p')
         ->orderBy('p.published_at', 'DESC')
         ;
   }

}
