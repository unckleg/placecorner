<?php

namespace AdminBundle\Model\Repository;

use AdminBundle\Model\Entity\Page;
use App\CoreBundle\Model\Constants;
use App\CoreBundle\Service\Validator\Validator;
use Doctrine\ORM\EntityRepository;

/**
 * PageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PageRepository extends EntityRepository implements Constants
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
    public function modifyPage($id, $status)
    {
        $id     = (int) $id;
        $status = (string) $status;
        $field  = self::$modifyFields[$status];

        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->update(Page::class, 'p')
            ->set('p.' . $field, '1-p.'.$field)
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute()
        ;
    }

    /**
     * @param  string $locale
     * @return array
     */
    public function findAllByLocale($locale = null)
    {
        $locale = !empty($locale) ?
            $locale :
            self::DEFAULT_LOCALE;

        return $this
            ->createQueryBuilder('p')
            ->select('p, t')
            ->leftJoin('p.translations', 't')
            ->where('t.locale = :locale')
            ->andWhere('p.isDeleted = :deleted')
            ->setParameter('deleted', Constants::IS_ACTIVE)
            ->setParameter('locale', $locale)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Returns null or array if found translated content for provided Id
     * @param  string $locale
     * @param  integer $id
     * @return array|null
     */
    public function findOrFailByLocale($locale, $id)
    {
        // validation of passed variables
        Validator::isValid($locale, Validator::IS_STRING);
        Validator::isValid($id, Validator::IS_NUMERIC);
        $locale = strtolower($locale);

        $qb = $this
            ->createQueryBuilder('p')
            ->select('p, t')
            ->leftJoin('p.translations', 't')
            ->where('t.locale = :locale')
            ->andWhere('p.isDeleted = :deleted')
            ->andWhere('p.id = :id')
            ->setParameter('locale', $locale)
            ->setParameter('deleted', Constants::IS_ACTIVE)
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
        return $qb;
    }
}
