<?php

namespace Tracker\CompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TrackerCompanyBundle:Default:index.html.twig', array('name' => $name));
    }
}
