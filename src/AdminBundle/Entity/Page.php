<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Page
 *
 * @ORM\Table(name="page")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\PageRepository")
 */
class Page
{
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @param  string $method
     * @param  array $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (!method_exists(self::getTranslationEntityClass(), $method)) {
            $method = 'get' . ucfirst($method);
        }
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;

    /**
     * @var int
     *
     * @ORM\Column(name="is_deleted", type="smallint")
     */
    private $isDeleted;

    /**
     * @var int
     *
     * @ORM\Column(name="order_number", type="integer")
     */
    private $orderNumber;


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
     * Set image
     *
     * @param string $image
     *
     * @return Page
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Page
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
     * @param integer $isDeleted
     *
     * @return Page
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return int
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
     * @return Page
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
}
