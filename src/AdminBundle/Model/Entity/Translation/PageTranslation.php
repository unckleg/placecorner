<?php

namespace AdminBundle\Model\Entity\Translation;

use App\CoreBundle\Model\Translation\TranslationTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class PageTranslation
{
    use TranslationTrait;

    /**
     * @ORM\Column(type="string", length=500)
     */
    protected $title;

    /**
     * @ORM\Column(type="text")
     */
    protected $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $seo_title;

    /**
     * @ORM\Column(type="string", length=500)
     */
    protected $seo_description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $seo_keywords;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getSeoTitle()
    {
        return $this->seo_title;
    }

    /**
     * @param mixed $seo_title
     */
    public function setSeoTitle($seo_title)
    {
        $this->seo_title = $seo_title;
    }

    /**
     * @return mixed
     */
    public function getSeoDescription()
    {
        return $this->seo_description;
    }

    /**
     * @param mixed $seo_description
     */
    public function setSeoDescription($seo_description)
    {
        $this->seo_description = $seo_description;
    }

    /**
     * @return mixed
     */
    public function getSeoKeywords()
    {
        return $this->seo_keywords;
    }

    /**
     * @param mixed $seo_keywords
     */
    public function setSeoKeywords($seo_keywords)
    {
        $this->seo_keywords = $seo_keywords;
    }


}