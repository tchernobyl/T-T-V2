<?php

namespace Tracker\ResourceBundle\Controller;

use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;

class ResourceController extends FOSRestController
{
    /**
     * @param ParamFetcher $paramFetcher
     * @param $repository
     * @return mixed
     */
    public function findAll(ParamFetcher $paramFetcher, $repository)
    {

        $pageSize = $paramFetcher->get("pageSize");
        $page = $paramFetcher->get("page");
        $repository = $this->getDoctrine()
            ->getRepository($repository);
        $query = $repository->createQueryBuilder('c')
            ->getQuery();
        return $query->setMaxResults($pageSize)->setFirstResult(($page - 1) * $pageSize)->getResult();
    }

    /**
     * @param ParamFetcher $paramFetcher
     * @param $repository
     * @return mixed
     */
    public function findOneById(ParamFetcher $paramFetcher, $repository)
    {
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository($repository)->findById($paramFetcher->get('id'));
    }

    /**
     * @param Request $request
     * @param $repository
     * @param string $format
     * @return object
     */
    public function createNew(Request $request, $repository, $format = "json")
    {
        $normalizer = new GetSetMethodNormalizer();
        $encoder = new JsonEncoder();
        $serializer = new Serializer(array($normalizer), array($encoder));

        $objectFromContent = $serializer->deserialize($request->getContent(), $repository, $format);

        $relations = $objectFromContent->Relations();

        while (current($relations)) {
            $em = $this->getDoctrine()->getManager();
            $method = key($relations);
            $getMethod = "get" . $method;
            $setMethod = "set" . $method;
            $repository = $relations[key($relations)]["Repository"];
            $ObjectFromDb = $em->getRepository($repository)->find($objectFromContent->$getMethod());
            $objectFromContent->$setMethod($ObjectFromDb);
            next($relations);
        }


        $em = $this->getDoctrine()->getManager();


        $em->persist($objectFromContent);
        $em->flush();

        return $objectFromContent;
    }

    public function update(Request $request, ParamFetcher $paramFetcher, $repository, $format = "json")
    {

        $id = $paramFetcher->get('id');
        $em = $this->getDoctrine()->getManager();
        $ObjectFromDb = $em->getRepository($repository)->find($id);
        $securityContext = $this->get('security.context');


        if (false === $securityContext->isGranted('EDIT', $ObjectFromDb)) {
            throw new AccessDeniedException();
        }
        $data = json_decode($request->getContent(), true);
        while (current($data)) {
            $ObjectFromDb->setOption(key($data), $data[key($data)]);
            next($data);
        }
        $em = $this->getDoctrine()->getManager();
        $em->flush();


        return $ObjectFromDb;
    }


    /**
     * @param $object
     */
    public function createOwnerRole($object)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        /** creating the ACL**/
        $aclProvider = $this->get('security.acl.provider');
        $objectIdentity = ObjectIdentity::fromDomainObject($object);
        $acl = $aclProvider->createAcl($objectIdentity);
        /**  retrieving the security identity of the currently logged-in user **/
        $securityIdentity = UserSecurityIdentity::fromAccount($user);
        /** grant owner access**/
        $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
        $aclProvider->updateAcl($acl);
    }

    /**
     * @param ParamFetcher $paramFetcher
     * @QueryParam(name="id_object")
     * @QueryParam(name="id_user")
     * @QueryParam(name="role")
     * @param $repository
     * @return array
     */
    public function addRoleForUserInObject(ParamFetcher $paramFetcher, $repository)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('Tracker\UserBundle\Entity\User')->find($paramFetcher->get('id_user'));
        $object = $em->getRepository($repository)->find($paramFetcher->get('id_object'));
        $role = $paramFetcher->get('role');
        /** creating the ACL**/
        $aclProvider = $this->get('security.acl.provider');
        $objectIdentity = ObjectIdentity::fromDomainObject($object);
        $acl = $aclProvider->createAcl($objectIdentity);
        /**  retrieving the security identity of the currently logged-in user **/
        $securityIdentity = UserSecurityIdentity::fromAccount($user);
        /** grant owner access**/
        $acl->insertObjectAce($securityIdentity, 32);
        $aclProvider->updateAcl($acl);
        return array("Status" => "OK");
    }

    /**
     * @param $CompanyFound
     * @param $user
     * @return bool
     */
    private function VerifyExistingRelationUserCompany($CompanyFound, $user)
    {
        //TODO correct this function and complete the whole of the api related with the ACLS
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


    public function RetrivingObjectAcl()
    {
//        $thread = "";
//
//        $provider =$container->get('security.acl.provider');
//
//        $acl = $provider->findAcl(ObjectIdentity::fromDomainObject($thread));
    }


    /**
     * @return \FOS\RestBundle\View\ViewHandler
     */
    public function getViewHandler()
    {
        return $this->container->get('fos_rest.view_handler');
    }
}
