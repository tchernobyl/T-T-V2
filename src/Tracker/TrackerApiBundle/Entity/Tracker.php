<?php

namespace Tracker\TrackerApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tracker
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Tracker\TrackerApiBundle\Repository\TrackerRepository")
 */
class Tracker
{
    /**
     * @var string
     */
    private $imageDecoded;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_tracker", type="datetime")
     */
    private $dateTracker;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_at", type="datetime")
     */
    private $startAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="stop_at", type="datetime")
     */
    private $stopAt;

    /**
     * @var float
     *
     * @ORM\Column(name="elapsed_time", type="float")
     */
    private $elapsedTime;

    /**
     * @var string
     *
     * @ORM\Column(name="binary_screen", type="text")
     */
    private $binaryScreen;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbr_tapped_key", type="integer")
     */
    private $nbrTappedKey;

    /**
     * @var integer
     * @ORM\Column(name="count_key", type="integer")
     */
    private $countKey;

    /**
     * @var integer
     * @ORM\Column(name="count_mouse", type="integer" ,nullable=true)
     */
    private $countMouse;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbr_clicked_mouse", type="integer")
     */
    private $nbrClickedMouse;

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
     * @var string
     *
     * @ORM\Column(name="local_session", type="text")
     */
    private $localSession;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Tracker\TrackerApiBundle\Entity\TrackerSession")
     * @ORM\JoinColumn
     */
    private $tracker_session;

    /**
     * @param int $tracker_session
     * @return Tracker
     */
    public function setTrackerSession($tracker_session)
    {
        $this->tracker_session = $tracker_session;
        return $this;
    }

    /**
     * @return int
     */
    public function getTrackerSession()
    {
        return $this->tracker_session;
    }

    public function getImageDecoded()
    {

        return base64_decode($this->getBinaryScreen());
    }

    public function setImageDecoded()
    {
        $this->imageDecoded = base64_decode($this->getBinaryScreen());
        return $this;
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
     *  Set localSession
     *
     * @param string $localSession
     * @return Tracker
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateTracker
     *
     * @param \DateTime $dateTracker
     * @return Tracker
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
     * Set startAt
     *
     * @param \DateTime $startAt
     * @return Tracker
     */
    public function setStartAt($startAt)
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * Get startAt
     *
     * @return \DateTime
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * Set stopAt
     *
     * @param \DateTime $stopAt
     * @return Tracker
     */
    public function setStopAt($stopAt)
    {
        $this->stopAt = $stopAt;

        return $this;
    }

    /**
     * Get stopAt
     *
     * @return \DateTime
     */
    public function getStopAt()
    {
        return $this->stopAt;
    }

    /**
     * Set elapsedTime
     *
     * @param float $elapsedTime
     * @return Tracker
     */
    public function setElapsedTime($elapsedTime)
    {
        $this->elapsedTime = $elapsedTime;

        return $this;
    }

    /**
     * Get elapsedTime
     *
     * @return float
     */
    public function getElapsedTime()
    {
        return $this->elapsedTime;
    }

    /**
     * Set binaryScreen
     *
     * @param string $binaryScreen
     * @return Tracker
     */
    public function setBinaryScreen($binaryScreen)
    {
        $this->binaryScreen = $binaryScreen;

        return $this;
    }

    /**
     * Get binaryScreen
     *
     * @return string
     */
    public function getBinaryScreen()
    {
        return $this->binaryScreen;
    }

    /**
     * Set nbrTappedKey
     *
     * @param integer $nbrTappedKey
     * @return Tracker
     */
    public function setNbrTappedKey($nbrTappedKey)
    {
        $this->nbrTappedKey = $nbrTappedKey;

        return $this;
    }

    /**
     * Get nbrTappedKey
     *
     * @return integer
     */
    public function getNbrTappedKey()
    {
        return $this->nbrTappedKey;
    }

    /**
     * Set nbrClickedMouse
     *
     * @param integer $nbrClickedMouse
     * @return Tracker
     */
    public function setNbrClickedMouse($nbrClickedMouse)
    {
        $this->nbrClickedMouse = $nbrClickedMouse;

        return $this;
    }

    /**
     * Get nbrClickedMouse
     *
     * @return integer
     */
    public function getNbrClickedMouse()
    {
        return $this->nbrClickedMouse;
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

    /**
     * @param int $countKey
     * @return Tracker
     *
     */
    public function setCountKey($countKey)
    {
        $this->countKey = $countKey;
        return $this;
    }

    /**
     * @return integer
     */
    public function getCountKey()
    {
        return $this->countKey;
    }

    /**
     * @param int $countMouse
     * @return Tracker
     *
     */
    public function setCountMouse($countMouse)
    {
        $this->countMouse = $countMouse;
        return $this;
    }

    /**
     * @return integer
     */
    public function getCountMouse()
    {
        return $this->countMouse;
    }

    public function Relations()
    {
        return array(
            "TrackerSession" => array("Repository"=>'Tracker\TrackerApiBundle\Entity\TrackerSession',"nullable"=> false),
            "UserId" => array("Repository"=>'Tracker\UserBundle\Entity\User', "nullable"=> false),
            "IdProject" => array("Repository"=>'Tracker\ProjectBundle\Entity\Project', "nullable"=> false)
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
