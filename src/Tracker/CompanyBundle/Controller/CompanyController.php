<?php

namespace Tracker\CompanyBundle\Controller;

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
use Tracker\CompanyBundle\Entity\Company;
use Tracker\ResourceBundle\Controller\ResourceController;



/**
 * Tracker controller.
 *
 * @Route("/azzz")
 */
class CompanyController extends ResourceController
{
    /**
     * @param ParamFetcher $paramFetcher
     * @QueryParam(name="pageSize")
     * @QueryParam(name="page")
     *@Route("/ttt", name="tracker")
     * @Method("GET")
     * @return View
     */
    public function getCompaniesAction(ParamFetcher $paramFetcher)
    {

        $CompaniesFound=$this->findAll($paramFetcher,$this->getRepository());

        $view = View::create()->setStatusCode(200)
            ->setData(array('Companies' => $CompaniesFound));

        return $this->getViewHandler()->handle($view);


    }
    /**
     *
     * @param ParamFetcher $paramFetcher
     * @QueryParam(name="id")
     * @return View
     */
    public function getCompanyAction(ParamFetcher $paramFetcher)
    {


        $CompaniesFound=$this->findOneById($paramFetcher,$this->getRepository());
        $view = View::create()->setStatusCode(200)
            ->setData(array('Companies' => $CompaniesFound));
        return $this->getViewHandler()->handle($view);
    }
    /**
     *@param Request $request
     * @return View
     */
    public function postCompaniesAction(Request $request)
    {

        $company=$this->createNew($request,$this->getRepository());
        $view = View::create()->setStatusCode(200)
            ->setData(array('Company' =>$company));
        return $this->getViewHandler()->handle($view);
    }

    /**
     * @param ParamFetcher $paramFetcher
     * @param Request $request
     * @QueryParam(name="id")
     * @return View
     */
    public function putCompanyAction(Request $request,ParamFetcher $paramFetcher){
        $CompanyFromDb=$this->update($request,$paramFetcher,$this->getRepository());
        $view = View::create()->setStatusCode(200)
            ->setData(array('Company' =>$CompanyFromDb));
        return $this->getViewHandler()->handle($view);

    }


    private function getRepository(){
        return 'Tracker\CompanyBundle\Entity\Company';
    }
}
