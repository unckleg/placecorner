<?php

namespace AdminBundle\Model\Repository;

use AdminBundle\Model\Entity\Newsletter;
use App\CoreBundle\Model\Constants;
use Doctrine\ORM\EntityRepository;

/**
 * NewsletterRepository
 */
class NewsletterRepository extends EntityRepository
    implements Constants
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
    public function modifySubscriber($id, $status)
    {
        $id     = (int) $id;
        $status = (string) $status;
        $field  = self::$modifyFields[$status];

        if ($status == self::DELETE_STRING) {
            $em = $this->getEntityManager();
            $em->remove(self::find($id));
            $em->flush();
            // returned string just to get status 200 on json response in controller
            return self::DELETE_STRING;
        }

        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->update(Newsletter::class, 'n')
            ->set('n.' . $field, '1-n.'.$field)
            ->where('n.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute()
        ;
    }
}
