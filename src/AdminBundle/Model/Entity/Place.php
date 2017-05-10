<?php

namespace AdminBundle\Model\Entity;

use App\CoreBundle\Model\Translation\TranslatableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Place
 *
 * @ORM\Table(name="place")
 * @ORM\Entity(repositoryClass="AdminBundle\Model\Repository\PlaceRepository")
 */
class Place
{
    use TranslatableTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var int
     *
     * @ORM\Column(name="user_type", type="integer")
     */
    protected $userType;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    protected $userId;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="places")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    protected $countryId;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="places")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    protected $regionId;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="City", inversedBy="places")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    protected $cityId;

    /**
     * @var int
     *
     * @ORM\Column(name="municipality_id", type="integer", nullable=true)
     */
    protected $municipalityId;

    /**
     * @var int
     *
     * @ORM\Column(name="gallery_id", type="integer", nullable=true)
     */
    protected $galleryId;

    /**
     * @var string
     *
     * @ORM\Column(name="map", type="string", length=500)
     */
    protected $map;

    /**
     * @var string
     *
     * @ORM\Column(name="working_hours", type="text")
     */
    protected $workingHours;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=500)
     */
    protected $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=45)
     */
    protected $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=100, nullable=true)
     */
    protected $website;

    /**
     * @var int
     *
     * @ORM\Column(name="views", type="integer")
     */
    protected $views;

    /**
     * @var string
     *
     * @ORM\Column(name="social_facebook", type="string", length=1000, nullable=true)
     */
    protected $socialFacebook;

    /**
     * @var string
     *
     * @ORM\Column(name="social_youtube", type="string", length=1000, nullable=true)
     */
    protected $socialYoutube;

    /**
     * @var string
     *
     * @ORM\Column(name="social_instagram", type="string", length=1000, nullable=true)
     */
    protected $socialInstagram;

    /**
     * @var string
     *
     * @ORM\Column(name="social_twitter", type="string", length=1000, nullable=true)
     */
    protected $socialTwitter;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    protected $status = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_deleted", type="boolean")
     */
    protected $isDeleted = 0;


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
     * Set userType
     *
     * @param integer $userType
     *
     * @return Place
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;

        return $this;
    }

    /**
     * Get userType
     *
     * @return int
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Place
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set countryId
     *
     * @param integer $countryId
     *
     * @return Place
     */
    public function setCountry($countryId)
    {
        $this->countryId = $countryId;

        return $this;
    }

    /**
     * Get countryId
     *
     * @return int
     */
    public function getCountry()
    {
        return $this->countryId;
    }

    /**
     * Set regionId
     *
     * @param integer $regionId
     *
     * @return Place
     */
    public function setRegion($regionId)
    {
        $this->regionId = $regionId;

        return $this;
    }

    /**
     * Get regionId
     *
     * @return int
     */
    public function getRegion()
    {
        return $this->regionId;
    }

    /**
     * Set cityId
     *
     * @param integer $cityId
     *
     * @return Place
     */
    public function setCity($cityId)
    {
        $this->cityId = $cityId;

        return $this;
    }

    /**
     * Get cityId
     *
     * @return int
     */
    public function getCity()
    {
        return $this->cityId;
    }

    /**
     * Set municipalityId
     *
     * @param integer $municipalityId
     *
     * @return Place
     */
    public function setMunicipality($municipalityId)
    {
        $this->municipalityId = $municipalityId;

        return $this;
    }

    /**
     * Get municipalityId
     *
     * @return int
     */
    public function getMunicipality()
    {
        return $this->municipalityId;
    }

    /**
     * Set galleryId
     *
     * @param integer $galleryId
     *
     * @return Place
     */
    public function setGalleryId($galleryId)
    {
        $this->galleryId = $galleryId;

        return $this;
    }

    /**
     * Get galleryId
     *
     * @return int
     */
    public function getGalleryId()
    {
        return $this->galleryId;
    }

    /**
     * Set map
     *
     * @param string $map
     *
     * @return Place
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

    /**
     * Set workingHours
     *
     * @param string $workingHours
     *
     * @return Place
     */
    public function setWorkingHours($workingHours)
    {
        $this->workingHours = $workingHours;

        return $this;
    }

    /**
     * Get workingHours
     *
     * @return string
     */
    public function getWorkingHours()
    {
        return $this->workingHours;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Place
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Place
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Place
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return Place
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set views
     *
     * @param integer $views
     *
     * @return Place
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return int
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set socialFacebook
     *
     * @param string $socialFacebook
     *
     * @return Place
     */
    public function setSocialFacebook($socialFacebook)
    {
        $this->socialFacebook = $socialFacebook;

        return $this;
    }

    /**
     * Get socialFacebook
     *
     * @return string
     */
    public function getSocialFacebook()
    {
        return $this->socialFacebook;
    }

    /**
     * Set socialYoutube
     *
     * @param string $socialYoutube
     *
     * @return Place
     */
    public function setSocialYoutube($socialYoutube)
    {
        $this->socialYoutube = $socialYoutube;

        return $this;
    }

    /**
     * Get socialYoutube
     *
     * @return string
     */
    public function getSocialYoutube()
    {
        return $this->socialYoutube;
    }

    /**
     * Set socialInstagram
     *
     * @param string $socialInstagram
     *
     * @return Place
     */
    public function setSocialInstagram($socialInstagram)
    {
        $this->socialInstagram = $socialInstagram;

        return $this;
    }

    /**
     * Get socialInstagram
     *
     * @return string
     */
    public function getSocialInstagram()
    {
        return $this->socialInstagram;
    }

    /**
     * Set socialTwitter
     *
     * @param string $socialTwitter
     *
     * @return Place
     */
    public function setSocialTwitter($socialTwitter)
    {
        $this->socialTwitter = $socialTwitter;

        return $this;
    }

    /**
     * Get socialTwitter
     *
     * @return string
     */
    public function getSocialTwitter()
    {
        return $this->socialTwitter;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Place
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
     * @return Place
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
}
