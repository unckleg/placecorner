<?php

namespace FrontBundle\Model\Repository;

use AdminBundle\Model\Entity\Category;
use AdminBundle\Model\Entity\City;
use AdminBundle\Model\Entity\Place;
use App\CoreBundle\Model\Constants;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class FrontRepository implements Constants
{
    /**
     * @var EntityManager $em
     */
    private $em;

    /**
     * @var Serializer $serializer
     */
    private $serializer;

    /**
     * EntityManager injected trough service container
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em    = $em;
        $encoders    = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer  = new Serializer($normalizers, $encoders);
        $this->serializer = $serializer;
    }

    /**
     * @param  null $locale
     * @param  string $type
     * @return mixed
     */
    public function getPlacesJson($locale = null, $type = self::TYPE_JSON)
    {
        $locale = !empty($locale) ?
        $locale : self::DEFAULT_LOCALE;

        $places = $this->em
            ->getRepository(Place::class)
            ->createQueryBuilder('p')
            ->select('p, t')
            ->leftJoin('p.translations', 't')
            ->where('p.isDeleted = :notDeleted')
            ->andWhere('p.status = :active')
            ->andWhere('p.featured = :featured')
            ->setParameter('notDeleted', self::IS_ACTIVE)
            ->setParameter('active', self::STATUS_ACTIVE)
            ->setParameter('featured', Constants::PLACE_FEATURED)
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY)
        ;

        if (!empty($places)) {
            foreach ($places as $key => $place) {
                $latLong = explode(',', trim($place['map']));
                $places[$key]['latitude']  = $latLong[0];
                $places[$key]['longitude'] = $latLong[1];
                $places[$key]['longitude'] = $latLong[1];
                $places[$key]['image']     = '/uploads/place/' .$place['id'].'/featured/'. $place['image'];
                $places[$key]['title']     = $place['translations'][$locale]['title'];
            }
        }

        if ($type == self::TYPE_JSON) {
            return $this->serializer->serialize($places, self::TYPE_JSON);
        } else {
            return $places;
        }
    }

    /**
     * @param array $parameters
     * @param string $type
     * @return array|string|\Symfony\Component\Serializer\Encoder\scalar
     */
    public function getFilteredPlaces(array $parameters, $type = self::TYPE_ARRAY)
    {
        $locale = !empty($parameters['locale']) ?
        $parameters['locale'] : self::DEFAULT_LOCALE;

        $query = $this->em
            ->getRepository(Place::class)
            ->createQueryBuilder('p')
            ->select('p, t')
            ->leftJoin('p.translations', 't')
            ->where('p.isDeleted = :notDeleted')
            ->andWhere('p.status = :active')
            ->andWhere('p.featured  = :featured')
            ->setParameter('notDeleted', self::IS_ACTIVE)
            ->setParameter('active', self::STATUS_ACTIVE)
            ->setParameter('featured', Constants::PLACE_FEATURED)
        ;

        if (isset($parameters['city'])) {
            if (is_numeric($parameters['city'])) {
                $query
                    ->andWhere('p.cityId = :cityId')
                    ->setParameter('cityId', $parameters['city']);
            }
        }

        if (isset($parameters['categories'])) {
            if (is_numeric($parameters['categories'])) {
                $query->andWhere(':categoryId MEMBER OF p.categories')
                    ->setParameter('categoryId', $parameters['categories']);
            }
        }

        $places = $query->getQuery()->getResult(Query::HYDRATE_ARRAY);

        if (!empty($places)) {
            foreach ($places as $key => $place) {
                $latLong = explode(',', trim($place['map']));
                $places[$key]['latitude']  = $latLong[0];
                $places[$key]['longitude'] = $latLong[1];
                $places[$key]['longitude'] = $latLong[1];
                $places[$key]['image']     = '/uploads/place/' .$place['id'].'/featured/'. $place['image'];
                $places[$key]['title']     = $place['translations'][$locale]['title'];
            }
        }

        if ($type == self::TYPE_JSON) {
            return $this->serializer->serialize($places, self::TYPE_JSON);
        } else {
            return $places;
        }
    }

    /**
     * @param  null $locale
     * @return Place[]|array
     */
    public function getPlacesForSidebar($locale = null)
    {
        $locale = !empty($locale) ?
        $locale : self::DEFAULT_LOCALE;

        $places = $this->em->getRepository(Place::class)->findBy([
            'isDeleted' => Constants::IS_ACTIVE,
            'status'    => Constants::STATUS_ACTIVE,
            'featured'  => Constants::PLACE_FEATURED
        ]);

        return $places;
    }

    public function getCitiesPlacesCategories()
    {
        $em   = $this->em;
        $data = [];

        $data['places'] = $em->getRepository(Place::class)->findBy([
            'isDeleted' => Constants::IS_ACTIVE,
            'status'    => Constants::STATUS_ACTIVE]);
        $data['cities'] = $em->getRepository(City::class)->findBy([
            'isDeleted' => Constants::IS_ACTIVE,
            'isPopular' => Constants::CITY_POPULAR,
            'status'    => Constants::STATUS_ACTIVE]);
        $data['categories'] = $em->getRepository(Category::class)->findBy([
            'isDeleted' => Constants::IS_ACTIVE,
            'status'    => Constants::STATUS_ACTIVE
        ]);

        return $data;
    }
}