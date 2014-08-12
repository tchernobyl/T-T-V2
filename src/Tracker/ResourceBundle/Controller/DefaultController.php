<?php

namespace Tracker\ResourceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TrackerResourceBundle:Default:index.html.twig', array('name' => $name));
    }
}
