<?php


namespace Tracker\RoleBundle\Controller;

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
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Tracker\CompanyBundle\Entity\Company;
use Tracker\ResourceBundle\Controller\ResourceController;


class RoleController extends ResourceController
{

    /**
     * @param ParamFetcher $paramFetcher
     * @return array
     * @QueryParam(name="id_company", description="the id of company ")
     * @QueryParam(name="id_user", description="the id of user")
     *
     */
    public function RoleUserAction(ParamFetcher $paramFetcher)
    {
        $em = $this->getDoctrine()->getManager();
        $CompanyFound = $em->getRepository('TimeTrackerCompanyBundle:Company')->find($paramFetcher->get('id_company'));
        $userFound = $em->getRepository('TimeTrackerBundle:User')->find($paramFetcher->get('id_user'));
        $role = $this->getRoleUserCompany($CompanyFound, $userFound);
        return $role[0];

    }


    /**
     * @QueryParam(name="id_company")
     */
    public function addRolesUsersAction(ParamFetcher $paramFetcher, Request $request)
    {


        $id_company = $paramFetcher->get('id_company');
        $users = json_decode($request->getContent(), true);
        $company = $this->getDoctrine()->getRepository('TimeTrackerCompanyBundle:Company')->find($id_company);
        $i = array();
        foreach ($users as $user) {
            $us = $this->getDoctrine()->getRepository('TimeTrackerBundle:User')->find($user['id']);
            if ($us === $company->getUser()) {
                return "id user =id company  ";
            }

            if (true === $this->VerifyExistingRelationUserCompany($company, $us)) {
                return "lslsl";
            }
            $aclProvider = $this->get('security.acl.provider');
            $securityIdentity1 = UserSecurityIdentity::fromAccount($us);
            $idObjeto = ObjectIdentity::fromDomainObject($company);
            $acl = $this->get('security.acl.provider')->findAcl($idObjeto);
            $builder = new MaskBuilder();
            $builder
                ->add('view');
            $mask = $builder->get();
            $acl->insertObjectAce($securityIdentity1, $mask);
            $aclProvider->updateAcl($acl);


        }
        return $i;

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateExistingRoleUserAction(Request $request)
    {
        $requestR = json_decode($request->getContent(), true);
        $user = $requestR[0];
        $company = $requestR[1];
        $mask = $requestR[2];
        $companyFound = $this->getDoctrine()->getRepository('TimeTrackerCompanyBundle:Company')->find($company);
        $userFound = $this->getDoctrine()->getRepository('TimeTrackerBundle:User')->find($user);
        $maskFound = $this->getDoctrine()->getRepository('TimeTrackerRoleBundle:RoleUser')->find($mask['id']);
        $ResultUpdating = $this->updateRoleInCompany($userFound, $companyFound, $maskFound);
        return $ResultUpdating;
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function deleteExistingRoleUserAction(Request $request)
    {
        $requestR = json_decode($request->getContent(), true);
        $user = $requestR[0];
        $company = $requestR[1];

        $companyFound = $this->getDoctrine()->getRepository('TimeTrackerCompanyBundle:Company')->find($company);
        $userFound = $this->getDoctrine()->getRepository('TimeTrackerBundle:User')->find($user);

        $ResultUpdating = $this->deleteRoleInCompany($userFound, $companyFound);
        return $ResultUpdating;
    }

    /**
     * @QueryParam(name="id_company")
     * return all acls users related to company
     */
    public function listUserInCompanyAction(ParamFetcher $paramFetcher)
    {
        $id = $paramFetcher->get('id_company');
        $em = $this->getDoctrine()->getManager();
        $CompanyFound = $em->getRepository('TimeTrackerCompanyBundle:Company')->find($id);
        $IdObject = ObjectIdentity::fromDomainObject($CompanyFound);

        $acl = $this->get('security.acl.provider')->findAcl($IdObject);
        $aces = $acl->getObjectAces();


        $allUserInCompany = array();
        foreach ($aces as $ace) {

            $username = $ace->getSecurityIdentity()->getuserName();
            $usr = $em->getRepository('TimeTrackerBundle:User')->findBy(
                array('username' => $username)
            );
            if ($usr) {
                array_push($allUserInCompany, $usr[0]);
            }


        }
        return $allUserInCompany;


    }

    /**
     * @return mixed
     */
    public function listAllRolesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $roles = $em->getRepository('TimeTrackerRoleBundle:RoleUser')->findAll();
        return $roles;
    }

    /**
     * @param $CompanyFound
     * @param $user
     * @return bool
     */
    private function VerifyExistingRelationUserCompany($CompanyFound, $user)
    {
        $em = $this->getDoctrine()->getManager();

        $IdObject = ObjectIdentity::fromDomainObject($CompanyFound);
        $acl = $this->get('security.acl.provider')->findAcl($IdObject);
        $aces = $acl->getObjectAces();
        $result = false;

        foreach ($aces as $i => $ace) {

            $username = $ace->getSecurityIdentity()->getuserName();
            $usr = $em->getRepository('TimeTrackerBundle:User')->findBy(
                array('username' => $username)
            );
            if ($usr) {
                if ($user == $usr[0]) {


                    $result = true;
                    break;
                }
            }

        }

        return $result;
    }

    private function getRoleUserCompany($CompanyFound, $user)
    {
        $em = $this->getDoctrine()->getManager();
        $roleUser = null;
        $IdObject = ObjectIdentity::fromDomainObject($CompanyFound);
        $acl = $this->get('security.acl.provider')->findAcl($IdObject);
        $aces = $acl->getObjectAces();


        foreach ($aces as $i => $ace) {

            $username = $ace->getSecurityIdentity()->getuserName();

            $usr = $em->getRepository('TimeTrackerBundle:User')->findBy(
                array('username' => $username)
            );

            if ($user == $usr[0]) {

                $roleUser = $em->getRepository('TimeTrackerRoleBundle:RoleUser')->findBy(
                    array('mask' => $ace->getMask())
                );

                break;
            }
        }

        return $roleUser;
    }

    private function updateRoleInCompany($user, $company, $mask)
    {
        $em = $this->getDoctrine()->getManager();
        $IdObject = ObjectIdentity::fromDomainObject($company);
        $aclProvider = $this->get('security.acl.provider');
        $acl = $aclProvider->findAcl($IdObject);
        $aces = $acl->getObjectAces();
        $result = false;

        foreach ($aces as $i => $ace) {

            $username = $ace->getSecurityIdentity()->getuserName();
            $usr = $em->getRepository('TimeTrackerBundle:User')->findBy(
                array('username' => $username)
            );
            if ($usr) {
                if ($user == $usr[0]) {
                    $result = true;
                    $acl->updateObjectAce($i, $mask->getMask());
                    $aclProvider->updateAcl($acl);


                }
            }

        }

        return $result;

    }

    private function deleteRoleInCompany($user, $company)
    {
        $em = $this->getDoctrine()->getManager();
        $IdObject = ObjectIdentity::fromDomainObject($company);
        $aclProvider = $this->get('security.acl.provider');
        $acl = $aclProvider->findAcl($IdObject);
        $aces = $acl->getObjectAces();
        $result = false;

        foreach ($aces as $i => $ace) {

            $username = $ace->getSecurityIdentity()->getuserName();
            $usr = $em->getRepository('TimeTrackerBundle:User')->findBy(
                array('username' => $username)
            );

            if ($usr) {
                if ($user == $usr[0]) {
                    $result = true;
                    $acl->deleteObjectAce($i);
                    $aclProvider->updateAcl($acl);


                }
            }

        }

        return $result;

    }

}
