<?php

namespace AdminBundle\Model\Repository;

use AdminBundle\Form\Place\PlaceType;
use AdminBundle\Model\Entity\City;
use AdminBundle\Model\Entity\Country;
use AdminBundle\Model\Entity\Place;
use App\CoreBundle\Model\Constants;
use App\CoreBundle\Service\Validator\Validator;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

/**
 * PlaceRepository
 *
 */
class PlaceRepository extends EntityRepository
    implements Constants
{
    private static $modifyFields = [
        'hide'     => 'status',
        'show'     => 'status',
        'delete'   => 'isDeleted',
        'featured' => 'featured'
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
            ->createQueryBuilder('p')
            ->select('p, t')
            ->leftJoin('p.translations', 't')
            ->where('t.locale = :locale')
            ->andWhere('p.isDeleted = :deleted')
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
            ->createQueryBuilder('place')
            ->select('place, t')
            ->leftJoin('place.translations', 't')
            ->where('t.locale = :locale')
            ->andWhere('place.isDeleted = :deleted')
            ->andWhere('place.id = :id')
            ->setParameter('locale', $locale)
            ->setParameter('deleted', self::IS_ACTIVE)
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @param  Place $place | Place Entity passed with data from form
     * @param  $form        | PlaceType form with data
     * @return Place $place | Updated Place Entity
     */
    public function assignReferencedData(Place $place, $form)
    {
        $em   = $this->getEntityManager();
        $city = $em->getRepository(City::class)
            ->find($form->getData()->getCity());

        $place->setCity($city)
              ->setRegion($city->getRegion())
              ->setCountry($city->getRegion()->getCountry())
        ;

        return $place;
    }
}
