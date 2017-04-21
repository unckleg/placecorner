<?php

namespace AdminBundle\Model\Repository;

use AdminBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 **/
class UserRepository extends EntityRepository
{

    private static $modifyFields = [
        'hide'   => 'enabled',
        'show'   => 'enabled',
        'delete' => 'isDeleted'
    ];

    /**
     * @param  integer $id
     * @param  string $status
     * @return mixed
     */
    public function modifyUser($id, $status)
    {
        $id     = (int) $id;
        $status = (string) $status;
        $field  = self::$modifyFields[$status];
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->update(User::class, 'u')
            ->set('u.' . $field, '1-u.'.$field)
            ->where('u.id = :userid')
            ->setParameter('userid', $id)
            ->getQuery()
            ->execute()
        ;
    }

    /**
     * @param  array $criteria
     * @param  array|null $orderBy
     * @param  null $limit
     * @param  null $offset
     * @return array
     */
    public function findByNot(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $qb   = $this->getEntityManager()->createQueryBuilder();
        $expr = $this->getEntityManager()->getExpressionBuilder();

        $qb->select('entity')
           ->from($this->getEntityName(), 'entity');
        foreach ($criteria as $field => $value) {
            $qb->andWhere($expr->neq('entity.' . $field, $value));
        }
        if ($orderBy) {
            foreach ($orderBy as $field => $order) {
                $qb->addOrderBy('entity.' . $field, $order);
            }
        }

        if ($limit)
            $qb->setMaxResults($limit);
        if ($offset)
            $qb->setFirstResult($offset);

        return $qb->getQuery()
                  ->getResult();
    }
}
