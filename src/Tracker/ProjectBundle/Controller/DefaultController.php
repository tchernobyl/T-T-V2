<?php

namespace Tracker\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TrackerProjectBundle:Default:index.html.twig', array('name' => $name));
    }
}
