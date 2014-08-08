<?php

namespace Tracker\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * User
 * @ORM\Entity(repositoryClass="Tracker\UserBundle\Repository\UserRepository")
 * @ORM\Table()
 * @ORM\Entity()

 */
class User extends BaseUser implements  UserInterface, \Serializable
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }


    /**
     * @var string
     * @ORM\Column(name="last_name", type="string")
     *
     */
    private $lastName;

    /**
     * @var string
     * @ORM\Column(name="first_name", type="string")
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(name="api_key", type="string",nullable=false)
     */
    private $apiKey;

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="binary_screen", type="text",nullable=true)
     */
    private $binaryScreen;

    /**
     * @var integer
     * @ORM\Column(name="notifications", type="integer",nullable=true)
     */
    private $notifications = 0;

    /**
     * @var integer
     * @ORM\Column(name="messages", type="integer",nullable=true)
     */
    private $messages = 0;

    /**
     * @param int $messages
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
    }

    /**
     * @return int
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param int $notifications
     */
    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;
    }

    /**
     * @return int
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * @param string $binaryScreen
     */
    public function setBinaryScreen($binaryScreen)
    {
        $this->binaryScreen = $binaryScreen;
    }

    /**
     * @return string
     */
    public function getBinaryScreen()
    {
        return $this->binaryScreen;
    }


    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
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

}
