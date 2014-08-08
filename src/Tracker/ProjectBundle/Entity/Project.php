<?php

namespace Tracker\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * User
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table()
 * @ExclusionPolicy("none")
 * @ORM\Entity(repositoryClass="Tracker\ProjectBundle\Repository\ProjectRepository")
 */
class Project
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     * @ORM\Column(name="user_employer", type="integer")
     */
    protected $userEmployer;


    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Tracker\CompanyBundle\Entity\Company")
     * @ORM\JoinColumn
     *
     *
     */
    protected $company;
    /**
     * @var string
     * @ORM\Column(name="title", type="string")
     */
    protected $title;
    /**
     * @var string
     * @ORM\Column(name="description", type="string")
     */
    protected $description;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_convention", type="datetime",nullable=true)
     */
    protected $dateConvention;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_End", type="datetime",nullable=true)
     */
    protected $dateEnd;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    protected $enabled;

    /**
     * @param \DateTime $dateConvention
     * @return Project
     */
    public function setDateConvention($dateConvention)
    {
        $this->dateConvention = $dateConvention;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateConvention()
    {
        return $this->dateConvention;
    }

    /**
     * @param \DateTime $dateEnd
     * @return Project
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * @param string $description
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param int $id
     * @return Project
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $title
     * @return Project
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param int $userEmployer
     * @return Project
     */
    public function setUserEmployer($userEmployer)
    {
        $this->userEmployer = $userEmployer;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserEmployer()
    {
        return $this->userEmployer;
    }


    public function __toString()
    {
        return (string)$this->getTitle();
    }

    /**
     *
     * @param integer $company
     * @return $this
     */
    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return integer
     */
    public function getCompany()
    {
        return $this->company;
    }


    /**
     * @var string $image
     * @Assert\File( maxSize = "1024k", mimeTypesMessage = "Please upload a valid Image")
     * @ORM\Column(name="image", type="string", length=255 ,nullable=true)
     */
    private $image;


    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
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

    public function getFullImagePath()
    {
        return null === $this->image ? null : $this->getUploadRootDir() . $this->image;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return $this->getTmpUploadRootDir() . $this->getId() . "/";
    }

    protected function getTmpUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__ . '/../../../../web/upload/';
    }

    /**
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }


    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function uploadImage()
    {

        // the file property can be empty if the field is not required
        if (null === $this->image) {
            return;
        }
        if (!$this->id) {
            $this->image->move($this->getTmpUploadRootDir(), $this->image->getClientOriginalName());
        } else {
            $this->image->move($this->getUploadRootDir(), $this->image->getClientOriginalName());
        }
        $this->setImage($this->image->getClientOriginalName());
    }

    /**
     * @ORM\PostPersist()
     */
    public function moveImage()
    {
        if (null === $this->image) {
            return;
        }
        if (!is_dir($this->getUploadRootDir())) {
            mkdir($this->getUploadRootDir());
        }
        copy($this->getTmpUploadRootDir() . $this->image, $this->getFullImagePath());
        unlink($this->getTmpUploadRootDir() . $this->image);
    }
    public function setOptions(array $options)
    {
        $_classMethods = get_class_methods($this);

        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($options[0]);

            if (in_array($method, $_classMethods)) {

                $this->$method($value);
            }
        }
        return $this;
    }

    public function setOption($key, $value){
        return $this->setOptions(array($key, $value));
    }
    public function Relations(){
        return array(
            "Company" => array("Repository"=>'Tracker\CompanyBundle\Entity\Company',"nullable"=> false)
        );
    }

}
