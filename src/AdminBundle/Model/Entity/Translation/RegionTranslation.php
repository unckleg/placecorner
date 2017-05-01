<?php

namespace AdminBundle\Model\Entity\Translation;

use App\CoreBundle\Model\Translation\TranslationTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * RegionTranslation
 *
 * @ORM\Entity
 */
class RegionTranslation
{
    use TranslationTrait;
    

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=500)
     */
    protected $name;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return RegionTranslation
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

