<?php

namespace Tracker\ResourceBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
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
    public function findOneById(ParamFetcher $paramFetcher,$repository)
    {
        $em = $this->getDoctrine()->getManager();

        return  $em->getRepository($repository)->findById($paramFetcher->get('id'));
    }

    /**
     * @param Request $request
     * @param $repository
     * @param string $format
     * @return object
     */
    public function createNew(Request $request,$repository,$format="json"){
        $normalizer = new GetSetMethodNormalizer();
        $encoder = new JsonEncoder();
        $serializer = new Serializer(array($normalizer), array($encoder));

        $objectFromContent = $serializer->deserialize($request->getContent(),$repository,$format);

        $relations=$objectFromContent->Relations();

        while ( current($relations)) {
            $em = $this->getDoctrine()->getManager();
            $method=key($relations);
            $getMethod="get".$method;
            $setMethod="set".$method;
            $repository=$relations[key($relations)]["Repository"];

          $ObjectFromDb = $em->getRepository($repository)->find($objectFromContent->$getMethod());
          $objectFromContent->$setMethod($ObjectFromDb);

            next($relations);
        }



        $em = $this->getDoctrine()->getManager();


        $em->persist($objectFromContent);
        $em->flush();
        return $objectFromContent;
    }
    public function update(Request $request,ParamFetcher $paramFetcher,$repository,$format="json"){

        $id = $paramFetcher->get('id');
        $em = $this->getDoctrine()->getManager();
        $ObjectFromDb = $em->getRepository($repository)->find($id);
        $data = json_decode($request->getContent(), true);
        while ( current($data)) {
            $ObjectFromDb->setOption(key($data),$data[key($data)]);
            next($data);
        }
        $em = $this->getDoctrine()->getManager();
        $em->flush();



        return $ObjectFromDb;
    }



    /**
     * @return \FOS\RestBundle\View\ViewHandler
     */
    public function getViewHandler()
    {
        return $this->container->get('fos_rest.view_handler');
    }

    /**
     * @return array
     */
    public function UserfromtokenAction(){


        return array("4"=>"ddd");
    }

}
