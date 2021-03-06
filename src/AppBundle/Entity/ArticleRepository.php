<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends EntityRepository
{
    public function findAllOrderedByCreatedOnDESC()
    {
//        $dqlQuery = "SELECT COUNT(a) FROM AppBundle\Entity\Article a ORDER BY a.createdOn DESC";
//        $query = $this->getEntityManager()->createQuery($dqlQuery);
//        return $query->getResult();

        return $this->findBy([], ["createdOn" => "DESC"]);
    }

    public function count()
    {
        $dqlQuery = "SELECT COUNT(a) FROM AppBundle\Entity\Article a";
        $query = $this->getEntityManager()->createQuery($dqlQuery);
        return $query->getSingleScalarResult();
    }

    public function findAllWithOffsetAndLimitOrderedByCreatedOnDESC($offset, $limit)
    {
        $dqlQuery = "SELECT a, au FROM AppBundle\Entity\Article a JOIN a.author au ORDER BY a.createdOn DESC";
        $query = $this->getEntityManager()->createQuery($dqlQuery);
        $query->setFirstResult($offset);
        $query->setMaxResults($limit);
        return $query->getResult();

//        return $this->findBy([], ["createdOn" => "DESC"],$limit, $offset);
    }
}