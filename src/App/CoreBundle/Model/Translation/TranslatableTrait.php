<?php

namespace App\CoreBundle\Model\Translation;

use Knp\DoctrineBehaviors\Model\Translatable\Translatable;

trait TranslatableTrait
{
    use Translatable;

    /**
     * @inheritdoc
     */
    public static function getTranslationEntityClass()
    {
        $explodedNamespace = explode('\\', __CLASS__);
        $entityClass = array_pop($explodedNamespace);
        return '\\'.implode('\\', $explodedNamespace).'\\Translation\\'.$entityClass.'Translation';
    }
}