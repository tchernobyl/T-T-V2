<?php

namespace Tracker\ProjectBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Tracker\ProjectBundle\Entity\Project;
use Tracker\ResourceBundle\Controller\ResourceController;
class ProjectController extends ResourceController
{
    /**
     * @param ParamFetcher $paramFetcher
     * @QueryParam(name="pageSize")
     * @QueryParam(name="page")
     *
     * @return View
     */
    public function getProjectsAction(ParamFetcher $paramFetcher)
    {

        $ProjectsFound=$this->findAll($paramFetcher,$this->getRepository());
        $view = View::create()->setStatusCode(200)
            ->setData(array('Projects' => $ProjectsFound));

        return $this->getViewHandler()->handle($view);


    }

    /**
     *@param Request $request
     * @return View
     */
    public function postProjectsAction(Request $request)
    {

        $Project=$this->createNew($request,$this->getRepository());
        $view = View::create()->setStatusCode(200)
            ->setData(array('Projects' =>$Project));
        return $this->getViewHandler()->handle($view);
    }

    public function putProjectAction(Request $request,ParamFetcher $paramFetcher){
        $ProjectFromDb=$this->update($request,$paramFetcher,$this->getRepository());
        $view = View::create()->setStatusCode(200)
            ->setData(array('Projects' =>$ProjectFromDb));
        return $this->getViewHandler()->handle($view);

    }
    private function getRepository(){
        return 'Tracker\ProjectBundle\Entity\Project';
    }

}
