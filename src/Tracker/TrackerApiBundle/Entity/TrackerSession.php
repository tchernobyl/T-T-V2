<?php


namespace Tracker\TrackerApiBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * TrackerSession
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class TrackerSession
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
     * @ORM\Column(name="tracker_session", type="text")
     */
    private $trackerSession;

    /**
     * @var string
     *
     * @ORM\Column(name="local_session", type="text")
     */
    private $localSession;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_tracker", type="datetime")
     */
    private $dateTracker;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin_tracker", type="datetime",nullable=true)
     */
    private $dateFinTracker;

    /**
     * @var integer
     *
     * @ORM\Column(name="count_tracker", type="integer")
     */
    private $countTracker;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Tracker\UserBundle\Entity\User")
     * @ORM\JoinColumn
     */
    private $userId;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Tracker\ProjectBundle\Entity\Project")
     * @ORM\JoinColumn
     */
    private $idProject;

    /**
     * @var int
     * @ORM\Column(name="count_key",type="integer",nullable=true)
     */
    private $countKey;

    /**
     * @var int
     * @ORM\Column(name="count_mouse",type="integer",nullable=true)
     */
    private $countMouse;
    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Tracker\TrackerApiBundle\Entity\SessionTracker")
     * @ORM\JoinColumn
     */
    private $session_tracker;

    /**
     * @param int $session_tracker
     * @return TrackerSession
     */
    public function setSessionTracker($session_tracker)
    {
        $this->session_tracker = $session_tracker;
        return $this;
    }

    /**
     * @return int
     */
    public function getSessionTracker()
    {
        return $this->session_tracker;
    }

    /**
     * @param int $countKey
     * @return Tracker
     */
    public function setCountKey($countKey)
    {
        $this->countKey = $countKey;
        return $this;
    }

    /**
     * @return int
     */
    public function getCountKey()
    {
        return $this->countKey;
    }

    /**
     * @param int $countMouse
     * @return Tracker
     */
    public function setCountMouse($countMouse)
    {
        $this->countMouse = $countMouse;
        return $this;
    }

    /**
     * @return int
     */
    public function getCountMouse()
    {
        return $this->countMouse;
    }


    /**
     * @param int $idProject
     * @return Tracker
     */
    public function setIdProject($idProject)
    {
        $this->idProject = $idProject;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdProject()
    {
        return $this->idProject;
    }


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
     *  Set trackerSession
     *
     * @param string $trackerSession
     * @return TrackerSession
     */
    public function setTrackerSession($trackerSession)
    {
        $this->trackerSession = $trackerSession;
        return $this;
    }

    /**
     * Get trackerSession
     *
     * @return string
     */
    public function getTrackerSession()
    {
        return $this->trackerSession;
    }

    /**
     *  Set localSession
     *
     * @param string $localSession
     * @return TrackerSession
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
     * Set dateTracker
     *
     * @param \DateTime $dateTracker
     * @return TrackerSession
     */
    public function setDateTracker($dateTracker)
    {
        $this->dateTracker = $dateTracker;

        return $this;
    }

    /**
     * Get dateTracker
     *
     * @return \DateTime
     */
    public function getDateTracker()
    {
        return $this->dateTracker;
    }


    /**
     * Set dateFinTracker
     *
     * @param \DateTime $dateFinTracker
     * @return TrackerSession
     */
    public function setDateFinTracker($dateFinTracker)
    {
        $this->dateFinTracker = $dateFinTracker;

        return $this;
    }

    /**
     * Get dateFinTracker
     *
     * @return \DateTime
     */
    public function getDateFinTracker()
    {
        return $this->dateFinTracker;
    }

    /**
     * Set nbrClickedMouse
     *
     * @param integer $countTracker
     * @return TrackerSession
     */
    public function setCountTracker($countTracker)
    {
        $this->countTracker = $countTracker;

        return $this;
    }

    /**
     * Get countTracker
     *
     * @return integer
     */
    public function getCountTracker()
    {
        return $this->countTracker;
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
            "SessionTracker" => array("Repository"=>'Tracker\TrackerApiBundle\Entity\SessionTracker', "nullable"=> false),
            "IdProject" => array("Repository"=>'Tracker\ProjectBundle\Entity\Project', "nullable"=> false),
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