<?php

namespace AdminBundle\Model\Entity;

use App\CoreBundle\Model\Translation\TranslatableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JsonSerializable;

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
     * @ORM\Column(name="user_type", type="integer", nullable=true)
     */
    protected $userType;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
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
     * @var string
     * @Assert\NotBlank()
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
     * @ORM\Column(name="image", type="string", length=1000)
     */
    protected $image;

    /**
     * Many Place have Many Images.
     * @ORM\ManyToMany(targetEntity="Images")
     * @ORM\JoinTable(name="place_images",
     *      joinColumns={@ORM\JoinColumn(name="place_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="image_id", referencedColumnName="id", unique=true)}
     *      )
     */
    protected $images;

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
    protected $views = 0;

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
     * @var int
     *
     * @ORM\Column(name="featured", type="boolean")
     */
    protected $featured = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_deleted", type="boolean")
     */
    protected $isDeleted = 0;


    /**
     * Many Places have Many Tags.
     * @ORM\ManyToMany(targetEntity="Tag")
     * @ORM\JoinTable(name="place_tags",
     *      joinColumns={@ORM\JoinColumn(name="place_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")})
     */
    protected $tags;

    /**
     * Many Places have Many Categories.
     * @ORM\ManyToMany(targetEntity="Category")
     * @ORM\JoinTable(name="place_categories",
     *      joinColumns={@ORM\JoinColumn(name="place_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")})
     */
    protected $categories;

    public function __construct() {
        $this->tags       = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->images     = new ArrayCollection();
    }

    public function addCategories($categories)
    {
        foreach($categories as $category) {
            $this->categories[] = $category;
        }
        return $this;
    }

    public function addTags(Tag $tags)
    {
        foreach($tags as $tag) {
            $this->tags[] = $tag;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

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
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param  mixed $images
     * @return void
     */
    public function addImages($images)
    {
        if (is_array($images)) {
            foreach($images as $image) {
                $this->images[] = $image;
            }
        } else {
            $this->images->add($images);
        }
        return $this;
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
     * @return int
     */
    public function isFeatured()
    {
        return $this->featured;
    }

    /**
     * @param int $featured
     */
    public function setFeatured($featured)
    {
        $this->featured = $featured;
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

