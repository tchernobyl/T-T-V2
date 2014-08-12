<?php

namespace Tracker\RoleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TrackerRoleBundle:Default:index.html.twig', array('name' => $name));
    }
}
