<?php

namespace AdminBundle\Model\Repository;

use AdminBundle\Model\Entity\City;
use App\CoreBundle\Model\Constants;
use App\CoreBundle\Service\Validator\Validator;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\AbstractQuery;

class CityRepository extends EntityRepository implements Constants
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
    public function modifyCity($id, $status)
    {
        $id     = (int) $id;
        $status = (string) $status;
        $field  = self::$modifyFields[$status];

        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->update(City::class, 'c')
            ->set('c.' . $field, '1-c.'.$field)
            ->where('c.id = :id')
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
            ->createQueryBuilder('c')
            ->select('c, t')
            ->leftJoin('c.translations', 't')
            ->where('t.locale = :locale')
            ->andWhere('c.isDeleted = :deleted')
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
            ->createQueryBuilder('city')
            ->select('city, t')
            ->leftJoin('city.translations', 't')
            ->where('t.locale = :locale')
            ->andWhere('city.isDeleted = :deleted')
            ->andWhere('city.id = :id')
            ->setParameter('locale', $locale)
            ->setParameter('deleted', self::IS_ACTIVE)
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * findRegions Method used for fetching assoc array for Forms
     *  - create
     *  - edit
     *  - translate
     * @return array
     */
    public function findCities()
    {
        return $this
            ->createQueryBuilder('c')
            ->select(['t.name', 'c.id', 'c', 't'])
            ->leftJoin('c.translations', 't')
            ->where('t.locale = :locale')
            ->andWhere('c.isDeleted = :deleted')
            ->setParameter('deleted', self::IS_ACTIVE)
            ->setParameter('locale', self::DEFAULT_LOCALE)
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_ARRAY)
        ;
    }
}
