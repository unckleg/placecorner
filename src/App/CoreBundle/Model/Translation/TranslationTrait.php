<?php

namespace App\CoreBundle\Model\Translation;

use Knp\DoctrineBehaviors\Model\Translatable\Translation;

trait TranslationTrait
{
    use Translation;

    /**
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        $class = new static();
        if (method_exists($class ,$name)) {
            $class->$name($arguments);
        }
    }

    /**
     * @inheritdoc
     */
    public static function getTranslatableEntityClass()
    {
        $explodedNamespace = explode('\\', __CLASS__);
        $entityClass = array_pop($explodedNamespace);

        // Remove Translation namespace
        array_pop($explodedNamespace);
        return '\\'.implode('\\', $explodedNamespace).'\\'.substr($entityClass, 0, -11);
    }
}