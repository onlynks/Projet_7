<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use JMS\Serializer\SerializationContext;
use GuzzleHttp\Client;

class UserController extends Controller
{
    /**
     * @Route("/getToken", name="getToken")
     */
    public function getTokenAction(Request $request)
    {
        $code = $request->headers->get('code');
        $url = $request->headers->get('url');

        $codeManager = $this->get('codeManager');

        return new Response($codeManager->seekToken($code, $url));
    }

    /**
     * @Route("/getName", name="getName")
     */
    public function getNameAction(Request $request)
    {
        $username = $this->getUser()->getUsername();

        return new Response($username);
    }

    /**
     * @Route("/customer/{id}", name="customer_details")
     * @Method({"GET"})
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @param $id
     * @return Response
     */
    public function customerDetailsAction($id)
    {
        $customer = $this->getDoctrine()->getRepository('AppBundle:Customer')->find($id);

        if($customer->getOwner()->getUsername() == $this->getUser()->getUsername())
        {
            $validator = $this->container->get('Validator_service');
            if($validator->getErrors($customer))
            {
                return $validator->getMessage($customer);
            }

            $data = $this->get('jms_serializer')->serialize($customer, 'json');

            if (empty($customer)) {
                return new Response('Customer not found', Response::HTTP_NOT_FOUND);
            }

            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }
        else
        {
            return new Response('Vous n\'avez pas l\'accès à ces données.');// ajouter code HTTP
        }
    }

    /**
     * @Route("/customer", name="list_customers")
     * @Method({"GET"})
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function listCustomerAction()
    {
        $customers = $this->getUser()->getCustomer();
        $data = $this->get('jms_serializer')->serialize($customers, 'json', SerializationContext::create()->setGroups(array('list')));

        $response =  new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/test", name="test")
     */
    public function testAction(Request $request)
    {
        $path = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();

        return new Response($path);
    }




}
