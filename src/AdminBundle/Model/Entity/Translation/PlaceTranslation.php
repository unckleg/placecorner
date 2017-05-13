<?php

namespace AdminBundle\Model\Entity\Translation;

use App\CoreBundle\Model\Translation\TranslationTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * PlaceTranslation
 *
 * @ORM\Entity
 */
class PlaceTranslation
{
    use TranslationTrait;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=1000)
     * @Assert\NotBlank()
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(name="content", type="text", nullable=true)
     * @Assert\NotBlank()
     */
    protected $content;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="seo_title", type="string", length=500)
     */
    protected $seoTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_description", type="string", length=1000, nullable=true)
     */
    protected $seoDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_keywords", type="string", length=1000, nullable=true)
     */
    protected $seoKeywords;


    /**
     * Set title
     *
     * @param string $title
     *
     * @return PlaceTranslation
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

    /**
     * Set content
     *
     * @param string $content
     *
     * @return PlaceTranslation
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set seoTitle
     *
     * @param string $seoTitle
     *
     * @return PlaceTranslation
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
     * @return PlaceTranslation
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
     * @return PlaceTranslation
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

