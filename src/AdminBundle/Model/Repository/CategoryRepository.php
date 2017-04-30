<?php

namespace AdminBundle\Model\Repository;

use AdminBundle\Model\Entity\Category;
use App\CoreBundle\Model\Constants;
use App\CoreBundle\Service\Validator\Validator;
use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository implements Constants
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
    public function modifyCategory($id, $status)
    {
        $id     = (int) $id;
        $status = (string) $status;
        $field  = self::$modifyFields[$status];

        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->update(Category::class, 'p')
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
     * @param  integer $type
     * @return array
     */
    public function findAllByLocale($locale = null, $type = Constants::PARENT, $parentId = null)
    {
        $locale = !empty($locale) ?
            $locale :
            self::DEFAULT_LOCALE;

        $qb = $this
            ->createQueryBuilder('c')
            ->select('c, t')
            ->leftJoin('c.translations', 't')
            ->where('t.locale = :locale')
            ->andWhere('c.isDeleted = :deleted')
            ->setParameter('deleted', Constants::IS_ACTIVE)
            ->setParameter('locale', $locale)
        ;

        if ($type == Constants::PARENT) {
            // return just parents
            $qb->andWhere('c.parentId  = :isParent')
               ->setParameter('isParent', Constants::PARENT);
        } else {
            Validator::isValid($parentId, Validator::IS_NUMERIC);
            // where not equal 0 | return just subcategories
            $qb->andWhere('c.parentId  = :parentid')
               ->setParameter('parentid', $parentId);
        }

        return $qb->getQuery()
                  ->getResult();
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
            ->createQueryBuilder('c')
            ->select('c, t')
            ->leftJoin('c.translations', 't')
            ->where('t.locale = :locale')
            ->andWhere('c.isDeleted = :deleted')
            ->andWhere('c.id = :id')
            ->setParameter('locale', $locale)
            ->setParameter('deleted', Constants::IS_ACTIVE)
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $qb;
    }

    public function findParentsForSubcategoryForm()
    {
        $locale = !empty($locale) ?
            $locale :
            self::DEFAULT_LOCALE;

        $fields = ['t.title', 'c.id', 'c', 't'];
        $qb = $this
            ->createQueryBuilder('c')
            ->select($fields)
            ->leftJoin('c.translations', 't')
            ->where('t.locale = :locale')
            ->andWhere('c.isDeleted = :deleted')
            ->andWhere('c.parentId  = :isParent')
            ->setParameter('deleted', Constants::IS_ACTIVE)
            ->setParameter('locale', Constants::DEFAULT_LOCALE)
            ->setParameter('isParent', Constants::PARENT)
        ;

        return $qb->getQuery()
                  ->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
    }
}
