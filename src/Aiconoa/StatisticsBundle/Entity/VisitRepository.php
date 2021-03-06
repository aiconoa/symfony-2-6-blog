<?php

namespace Aiconoa\StatisticsBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * VisitRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VisitRepository extends EntityRepository
{
    public function findNumberOfVisitsPerPage()
    {
        $dqlQuery = "SELECT v.page, COUNT(v.page) as visit
                     FROM Aiconoa\StatisticsBundle\Entity\Visit v
                     GROUP BY v.page";
        $query = $this->getEntityManager()->createQuery($dqlQuery);
        return $query->getArrayResult();
    }
}
