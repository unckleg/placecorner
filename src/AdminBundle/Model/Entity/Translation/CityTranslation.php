<?php

namespace AdminBundle\Model\Entity\Translation;

use App\CoreBundle\Model\Translation\TranslationTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * CityTranslation
 *
 * @ORM\Entity
 */
class CityTranslation
{
    use TranslationTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=500)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_title", type="string", length=255)
     */
    private $seoTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_description", type="text")
     */
    private $seoDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_keywords", type="text")
     */
    private $seoKeywords;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return CityTranslation
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

    /**
     * Set seoTitle
     *
     * @param string $seoTitle
     *
     * @return CityTranslation
     */
    public function setSeoTitle($seoTitle)
    {
        $this->seoTitle = $seoTitle;

        return $this;
    }

    /**
     * Get seoTitle
     *
     * @return string
     */
    public function getSeoTitle()
    {
        return $this->seoTitle;
    }

    /**
     * Set seoDescription
     *
     * @param string $seoDescription
     *
     * @return CityTranslation
     */
    public function setSeoDescription($seoDescription)
    {
        $this->seoDescription = $seoDescription;

        return $this;
    }

    /**
     * Get seoDescription
     *
     * @return string
     */
    public function getSeoDescription()
    {
        return $this->seoDescription;
    }

    /**
     * Set seoKeywords
     *
     * @param string $seoKeywords
     *
     * @return CityTranslation
     */
    public function setSeoKeywords($seoKeywords)
    {
        $this->seoKeywords = $seoKeywords;

        return $this;
    }

    /**
     * Get seoKeywords
     *
     * @return string
     */
    public function getSeoKeywords()
    {
        return $this->seoKeywords;
    }
}

