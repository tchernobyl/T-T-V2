<?php


namespace Tracker\ProjectBundle\Repository;
use Doctrine\ORM\EntityRepository as BaseEntityRepository;
use Doctrine\ORM\QueryBuilder;

class ProjectRepository extends BaseEntityRepository {

    /**
     * {@inheritdoc}
     */
    public function testFirstFunction()
    {

echo "rrr";exit;
        return null ;
    }
}