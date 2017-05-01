<?php

namespace AdminBundle\Model\Repository;

use AdminBundle\Model\Entity\Region;
use App\CoreBundle\Model\Constants;
use App\CoreBundle\Service\Validator\Validator;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;

class RegionRepository extends EntityRepository implements Constants
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
    public function modifyRegion($id, $status)
    {
        $id     = (int) $id;
        $status = (string) $status;
        $field  = self::$modifyFields[$status];

        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->update(Region::class, 'r')
            ->set('r.' . $field, '1-r.'.$field)
            ->where('r.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute()
        ;
    }

    /**
     *
     * @param  string  $locale
     * @return array
     */
    public function findAllByLocale($locale = null)
    {
        $locale = !empty($locale) ?
            $locale : self::DEFAULT_LOCALE;

        return $this
            ->createQueryBuilder('r')
            ->select('r, t')
            ->leftJoin('r.translations', 't')
            ->where('t.locale = :locale')
            ->andWhere('r.isDeleted = :deleted')
            ->setParameter('deleted', self::IS_ACTIVE)
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

        return $this
            ->createQueryBuilder('region')
            ->select('region, t')
            ->leftJoin('region.translations', 't')
            ->where('t.locale = :locale')
            ->andWhere('region.isDeleted = :deleted')
            ->andWhere('region.id = :id')
            ->setParameter('locale', $locale)
            ->setParameter('deleted', self::IS_ACTIVE)
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
