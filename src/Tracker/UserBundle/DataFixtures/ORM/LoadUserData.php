<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pw2
 * Date: 1/27/14
 * Time: 12:04 PM
 * To change this template use File | Settings | File Templates.
 */


namespace Tracker\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;

use Doctrine\Common\DataFixtures\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Tracker\UserBundle\Entity\User;


class LoadUserData implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     */
    function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('pw2@gmail.com');
        $user->setPlainPassword("admin");
        $user->setEnabled(true);
        $user->setLocked(false);
        $user->setFirstName("pw2");
        $user->setLastName("portalsWay");
        $user->setBinaryScreen("lokjklsdjkjkl635gdfkjsd;:msdlosdkklsdklsdkjjklsdsdlksd");
        $user->setSuperAdmin(true);
        $user->setApiKey("oooo");


        $manager->persist($user);
        $manager->flush();
        $user = new User();
        $user->setUsername('tchernobyl');
        $user->setEmail('ameur@gmail.com');
        $user->setPlainPassword("tchernobyl");
        $user->setEnabled(true);
        $user->setLocked(false);
        $user->setFirstName("hamdouni");
        $user->setLastName("ameur");
        $user->setBinaryScreen("trtyfgygh;:msdlosdkklsdklsdkjjklsdsdlksd");
        $user->setApiKey("eeee");

        $manager->persist($user);
        $manager->flush();


    }
}