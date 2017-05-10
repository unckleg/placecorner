<?php

namespace AdminBundle\Model\Entity;

use App\CoreBundle\Model\Translation\TranslatableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table(name="country")
 * @ORM\Entity(repositoryClass="AdminBundle\Model\Repository\CountryRepository")
 */
class Country
{
    use TranslatableTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="Region", mappedBy="countryId")
     */
    protected $regions;

    /**
     * @ORM\OneToMany(targetEntity="Place", mappedBy="countryId")
     */
    protected $places;

    /**
     * Country constructor.
     */
    public function __construct() {
        $this->regions = new ArrayCollection();
        $this->places  = new ArrayCollection();
    }

    /**
     * Get regions
     *
     * @return ArrayCollection
     */
    public function getRegions()
    {
        return $this->regions;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status = 1;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_deleted", type="boolean")
     */
    private $isDeleted = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="order_number", type="integer")
     */
    private $orderNumber = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="map", type="string", length=500)
     */
    private $map;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Country
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return Country
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return bool
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Set orderNumber
     *
     * @param integer $orderNumber
     *
     * @return Country
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * Get orderNumber
     *
     * @return int
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * Set map
     *
     * @param string $map
     *
     * @return Country
     */
    public function setMap($map)
    {
        $this->map = $map;

        return $this;
    }

    /**
     * Get map
     *
     * @return string
     */
    public function getMap()
    {
        return $this->map;
    }
}

