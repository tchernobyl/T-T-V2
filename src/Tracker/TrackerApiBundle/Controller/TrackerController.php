<?php

namespace Tracker\TrackerApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Tracker\ResourceBundle\Controller\ResourceController;
use Tracker\TrackerApiBundle\Entity\Tracker;

class TrackerController extends ResourceController
{
    /**
     * @param ParamFetcher $paramFetcher
     * @QueryParam(name="pageSize")
     * @QueryParam(name="page")
     * @return View
     */
public function getTrackersAction(ParamFetcher $paramFetcher){

    $TrackerFound=$this->findAll($paramFetcher,$this->getRepository());
    $view = View::create()
        ->setStatusCode(200)
    ->setTemplate("rrr")
        ->setData(array('Trackers' => $TrackerFound));

    return $this->getViewHandler()->handle($view);
}


    public function postTrackerAction(Request $request){


        $Trackers=$this->createNew($request,$this->getRepository());

        $view = View::create()->setStatusCode(200)
            ->setData(array('Tracker' => $Trackers));

        return $this->getViewHandler()->handle($view);
    }

    private function getRepository(){
        return 'Tracker\TrackerApiBundle\Entity\Tracker';
    }
}
