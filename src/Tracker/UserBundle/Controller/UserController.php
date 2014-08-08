<?php

namespace Tracker\UserBundle\Controller;


use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\QueryParam;
class UserController extends Controller
{


    /**
     * @param ParamFetcher $paramFetcher
     * @QueryParam(name="token")
     * @return array
     */
    public function getUserbytokenAction(ParamFetcher $paramFetcher){
        $token = $paramFetcher->get("token");
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository($this->getRepository())->findBy(array("apiKey"=>$token));
        $view = View::create();


        if($user){
            $view
                ->setData(array('User' => $user[0]))
                ->setStatusCode(200);

        }else{
            $view
                ->setData(array('User' => "user not found"))
                ->setStatusCode(403);
        }
        return $this->getViewHandler()->handle($view);


    }
    /**
     * @return \FOS\RestBundle\View\ViewHandler
     */
    public function getViewHandler()
    {
        return $this->container->get('fos_rest.view_handler');
    }
    private function getRepository(){
        return 'Tracker\UserBundle\Entity\User';
    }
}
