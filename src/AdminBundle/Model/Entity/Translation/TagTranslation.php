<?php

namespace AdminBundle\Model\Entity\Translation;

use App\CoreBundle\Model\Translation\TranslationTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * TagTranslation
 *
 * @ORM\Entity
 */
class TagTranslation
{

    use TranslationTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * Set title
     *
     * @param string $title
     *
     * @return TagTranslation
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}

