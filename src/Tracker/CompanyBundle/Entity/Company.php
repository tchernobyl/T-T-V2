<?php
namespace Tracker\CompanyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\Config\Definition\Exception\Exception;
use JMS\Serializer\Annotation\MaxDepth;
/**
 * Company
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Company
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
     * @ORM\ManyToOne(targetEntity="Tracker\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

    /**
     * @var String
     * @ORM\Column(name="name_company", type="string")
     */
    protected $name_company;
    /**
     * @var integer
     * @ORM\OneToMany(targetEntity="Tracker\ProjectBundle\Entity\Project",mappedBy="company")
     * @ORM\JoinColumn
     * @MaxDepth(2)
     */
    protected $project;
    /**
     * @var String
     * @ORM\Column(name="description_company", type="string")
     */
    protected $description_company;

    /**
     * @var String
     * @ORM\Column(name="address_company", type="string")
     */
    protected $address_company;
    /**
     * @var String
     * @ORM\Column(name="phone_company", type="string")
     */
    protected $phone_company;

    /**
     * @param String $address_company
     */
    public function setAddressCompany($address_company)
    {
        $this->address_company = $address_company;
    }

    /**
     * @return String
     */
    public function getAddressCompany()
    {
        return $this->address_company;
    }

    /**
     * @param String $description_company
     */
    public function setDescriptionCompany($description_company)
    {
        $this->description_company = $description_company;
    }

    /**
     * @return String
     */
    public function getDescriptionCompany()
    {
        return $this->description_company;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param String $name_company
     */
    public function setNameCompany($name_company)
    {
        $this->name_company = $name_company;
    }

    /**
     * @return String
     */
    public function getNameCompany()
    {
        return $this->name_company;
    }

    /**
     * @param String $phone_company
     */
    public function setPhoneCompany($phone_company)
    {
        $this->phone_company = $phone_company;
    }

    /**
     * @return String
     */
    public function getPhoneCompany()
    {
        return $this->phone_company;
    }

    /**
     * @param int $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    public function __toString()
    {
        return (string)$this->getNameCompany();
    }

    /**
     * @param int $project
     */
    public function setProject($project)
    {
        $this->project = $project;
    }

    /**
     * @return int
     */
    public function getProject()
    {
        return $this->project;
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
        return array( "User" => array("Repository"=>'Tracker\UserBundle\Entity\User',"nullable"=> false));
    }
}