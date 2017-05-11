<?php

namespace AdminBundle\Model\Repository;

use AdminBundle\Model\Entity\Place;
use Doctrine\ORM\EntityRepository;

/**
 * PlaceRepository
 *
 */
class PlaceRepository extends EntityRepository
{
    private static $modifyFields = [
        'hide'   => 'status',
        'show'   => 'status',
        'delete' => 'isDeleted'
    ];

    /**
     * @param  integer $id
     * @param  string $status
     * @return mixed
     */
    public function modifyPlace($id, $status)
    {
        $id     = (int) $id;
        $status = (string) $status;
        $field  = self::$modifyFields[$status];

        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->update(Place::class, 'p')
            ->set('p.' . $field, '1-p.'.$field)
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute()
        ;
    }
}
