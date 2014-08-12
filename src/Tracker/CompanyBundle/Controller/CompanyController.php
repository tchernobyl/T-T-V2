<?php

namespace Tracker\CompanyBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Tracker\CompanyBundle\Entity\Company;
use Tracker\ResourceBundle\Controller\ResourceController;


class CompanyController extends ResourceController
{
    /**
     * @param ParamFetcher $paramFetcher
     * @QueryParam(name="pageSize")
     * @QueryParam(name="page")
     * @return View
     */
    public function getCompaniesAction(ParamFetcher $paramFetcher)
    {

        $CompaniesFound = $this->findAll($paramFetcher, $this->getRepository());
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
        if (!$paramFetcher->get('id')) {

            return $this->handleView(
                $this->view(array("response" => "Not found"), Codes::HTTP_NOT_FOUND)
            );
        }

        $CompaniesFound = $this->findOneById($paramFetcher, $this->getRepository());
        $view = View::create()->setStatusCode(200)
            ->setData(array('Companies' => $CompaniesFound));
        return $this->getViewHandler()->handle($view);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function postCompaniesAction(Request $request)
    {
        $company = $this->createNew($request, $this->getRepository());

        $this->createOwnerRole($company);


        $view = View::create()->setStatusCode(200)
            ->setData(array('Company' => $company));
        return $this->getViewHandler()->handle($view);
    }

    /**
     * @param ParamFetcher $paramFetcher
     * @param Request $request
     * @QueryParam(name="id")
     * @return View
     */
    public function putCompanyAction(Request $request, ParamFetcher $paramFetcher)
    {
        $CompanyFromDb = $this->update($request, $paramFetcher, $this->getRepository());
        $view = View::create()->setStatusCode(200)
            ->setData(array('Company' => $CompanyFromDb));
        return $this->getViewHandler()->handle($view);

    }


    /**
     * @param ParamFetcher $paramFetcher
     * @QueryParam(name="id_object")
     * @QueryParam(name="id_user")
     * @QueryParam(name="role")
     * @return View
     */
    public function postCompanyRoleAction(ParamFetcher $paramFetcher)
    {

//        $identity = new UserSecurityIdentity($userName, 'Tracker\UserBundle\Entity\User');
        $result = $this->addRoleForUserInObject($paramFetcher, $this->getRepository());

        $view = View::create()->setStatusCode(200)
            ->setData(array('Company' => $result));
        return $this->getViewHandler()->handle($view);
    }

    /**
     * Lists all Company entities.
     *
     */
    public function getCreateAction()
    {
        $view = View::create()->setStatusCode(200)

            ->setTemplate('TrackerCompanyBundle:Company:create.html.twig')
            ->setData(array('Users' => "ddd"));
        return $this->getViewHandler()->handle($view);

    }

    private function getRepository()
    {
        return 'Tracker\CompanyBundle\Entity\Company';
    }
}
