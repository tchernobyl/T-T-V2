<?php


namespace Tracker\TrackerApiBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * SessionTracker
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SessionTracker
{


    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="local_session", type="text")
     */
    private $localSession;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_session_start", type="datetime")
     */
    private $dateSessionStart;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_session_end", type="datetime",nullable=true)
     */
    private $dateSessionEnd;
    /**
     * @var integer
     *
     * @ORM\Column(name="count_tracker_session", type="integer")
     */
    private $countSession;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Tracker\UserBundle\Entity\User")
     * @ORM\JoinColumn
     */
    private $userId;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     *  Set localSession
     *
     * @param string $localSession
     * @return SessionTracker
     */
    public function setLocalSession($localSession)
    {
        $this->localSession = $localSession;
        return $this;
    }

    /**
     * Get localSession
     *
     * @return string
     */
    public function getLocalSession()
    {
        return $this->localSession;
    }

    /**
     * Set dateSessionStart
     * @param $dateSessionStart
     * @return SessionTracker
     */
    public function setDateSessionStart($dateSessionStart)
    {
        $this->dateSessionStart = $dateSessionStart;

        return $this;
    }

    /**
     * Get dateSessionStart
     *
     * @return \DateTime
     */
    public function getDateSessionStart()
    {
        return $this->dateSessionStart;
    }

    /**
     * Set dateSessionEnd
     *
     * @param $dateSessionEnd
     * @return SessionTracker
     */
    public function setDateSessionEnd($dateSessionEnd)
    {
        $this->dateSessionEnd = $dateSessionEnd;

        return $this;
    }

    /**
     * Get dateSessionEnd
     *
     * @return \DateTime
     */
    public function getDateSessionEnd()
    {
        return $this->dateSessionEnd;
    }

    /**
     * Set nbrClickedMouse
     *
     * @param integer $countSession
     * @return SessionTracker
     */
    public function setCountSession($countSession)
    {
        $this->countSession = $countSession;

        return $this;
    }

    /**
     * Get countTracker
     *
     * @return integer
     */
    public function getCountSession()
    {
        return $this->countSession;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return Tracker
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    public function __toString()
    {
        return (string)$this->getLocalSession();
    }
    public function Relations()
    {
        return array(

            "UserId" => array("Repository"=>'Tracker\UserBundle\Entity\User', "nullable"=> false),
        );
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