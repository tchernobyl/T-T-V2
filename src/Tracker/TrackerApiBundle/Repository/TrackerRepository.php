<?php


namespace Tracker\TrackerApiBundle\Repository;
use Doctrine\ORM\EntityRepository as BaseEntityRepository;
use Doctrine\ORM\QueryBuilder;

class TrackerRepository extends BaseEntityRepository {

    /**
     * {@inheritdoc}
     */
    public function saveTracker()
    {

echo 666;exit;
        return null ;
    }
}