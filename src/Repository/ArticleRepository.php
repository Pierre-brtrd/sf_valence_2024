<?php

namespace App\Repository;

use App\Entity\Article;
use App\Filter\ArticleFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findLatestArticle(int $limit, bool $includeDisable = false): array
    {
        $query = $this->createQueryBuilder('a');

        if (!$includeDisable) {
            $query->andWhere('a.enable = true');
        }

        return $query
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findFilterArticle(ArticleFilter $filter, bool $includeDisable = false): array
    {
        $sql = $this->createQueryBuilder('a');

        if (!$includeDisable) {
            $sql->andWhere('a.enable = true');
        }

        if ($filter->getQuery()) {
            $sql->andWhere('a.title LIKE :query')
                ->setParameter('query', "%{$filter->getQuery()}%");
        }

        if ($filter->getCategories()) {
            $sql
                ->join('a.categories', 'c')
                ->andWhere('c IN (:categories)')
                ->setParameter('categories', $filter->getCategories());
        }

        if ($filter->getAuthors()) {
            $sql
                ->join('a.user', 'u')
                ->andWhere('u IN (:authors)')
                ->setParameter('authors', $filter->getAuthors());
        }

        return $sql
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Article[] Returns an array of Article objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Article
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
