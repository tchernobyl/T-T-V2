<?php


namespace Tracker\UserBundle\Security;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Tracker\UserBundle\Security\ApplicationBoot;

class ApiKeyUserProvider implements UserProviderInterface
{

    public function getUsernameForApiKey($apiKey)
    {
        $container = ApplicationBoot::getContainer();
        $entityManager = $container->get('doctrine')->getEntityManager();
        $UserFound = $entityManager->getRepository('Tracker\UserBundle\Entity\User')->findBy(
            array("apiKey" => $apiKey)
        );
        if ($UserFound) {
            /**@var $user User */
            $user = $UserFound[0];
            $username = $user->getUsername();
        } else {
            $username = null;
        }
        return $username;
    }

    public function loadUserByUsername($username)
    {
        $container = ApplicationBoot::getContainer();
        $entityManager = $container->get('doctrine')->getEntityManager();

        $UserFound = $entityManager->getRepository('Tracker\UserBundle\Entity\User')->findBy(
            array("username" => $username)
        );

        /**@var $user User */
        $user = $UserFound[0];

        return new User(
            $username,
            null,
            // the roles for the user - you may choose to determine
            // these dynamically somehow based on the user
            array($user->getRoles())
        );
    }

    public function refreshUser(UserInterface $user)
    {
        // $user is the User that you set in the token inside authenticateToken()
        // after it has been deserialized from the session
        // you might use $user to query the database for a fresh user
        // $id = $user->getId();
        // use $id to make a query
        // if you are *not* reading from a database and are just creating
        // a User object (like in this example), you can just return it
        return $user;
    }

    public function supportsClass($class)
    {
        return 'Symfony\Component\Security\Core\User\User' === $class;
    }
}