<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use AppBundle\Form\CustomerType;

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

        return new Response($codeManager->seekToken($code, $url), Response::HTTP_OK);
    }

    /**
     * @Route("/getName", name="getName")
     */
    public function getNameAction(Request $request)
    {
        $username = $this->getUser()->getUsername();

        return new Response($username, Response::HTTP_OK);
    }

    /**
     * @Route("/customer/{id}", name="customer_details")
     * @Method({"GET"})
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @ApiDoc(
     *  section="Customer",
     *  resource=true,
     *  description="Get customer details",
     *  headers={
     *         {
     *             "name"="X-AUTH-TOKEN",
     *             "description"="Authorization token",
     *             "required"="true"
     *         }
     *     },
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirements"="\d+",
     *          "description"="The customer unique identifier."
     *      }
     *  }
     * )
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

            $response = new Response($data, Response::HTTP_OK);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }
        else
        {
            return new Response('Vous n\'avez pas l\'accès à ces données.', Response::HTTP_UNAUTHORIZED);// ajouter code HTTP
        }
    }

    /**
     * @Route("/customer", name="list_customers")
     * @Method({"GET"})
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @ApiDoc(
     *  section="Customer",
     *  resource=true,
     *  description="Get a customer list depending of parameters.",
     *  headers={
     *         {
     *             "name"="X-AUTH-TOKEN",
     *             "description"="Authorization token",
     *             "required"="true"
     *         }
     *     },
     *  parameters = {
     *         { "name" = "order", "dataType" = "string", "required"="false", "format" = "asc/desc" },
     *         { "name" = "maxPerPage", "dataType" = "integer", "required"="false" },
     *         { "name" = "currentPage", "dataType" = "integer", "required"="false" }
     *     }
     * )
     */
    public function listCustomerAction(Request $request)
    {
        $order = $request->query->get('order', 'asc');
        $maxPerPage = $request->query->get('maxPerPage', 10);
        $currentPage = $request->query->get('currentPage', 1);

        $pagerFanta = $this->getDoctrine()->getRepository('AppBundle:Customer')->search($order, $maxPerPage, $currentPage, $this->getUser()->getId());

        $data = $this->get('jms_serializer')->serialize((array)$pagerFanta->getCurrentPageResults(), 'json', SerializationContext::create()->setGroups(array('list')));

        $response = new Response($data, Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Method({"POST"})
     * @Route("/customer", name="create_customer")
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @ApiDoc(
     *  section="Customer",
     *  resource=true,
     *  description="Add a new customer",
     *  headers={
     *         {
     *             "name"="X-AUTH-TOKEN",
     *             "description"="Authorization token",
     *             "required"="true"
     *         }
     *     },
     * )
     */
    public function createAction(Request $request)
    {
        $data = $request->getContent();
        $customer = $this->get('jms_serializer')->deserialize($data, 'AppBundle\Entity\Customer', 'json');
        $customer->setOwner($this->getUser());
        $em = $this->getDoctrine()->getManager();
        $em->persist($customer);
        $em->flush();

        return new Response('Nouveau client ajouté.', Response::HTTP_CREATED);
    }

    /**
     * @Method({"PUT"})
     * @Route("/customer/{id}", name="update_customer")
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @ApiDoc(
     *  section="Customer",
     *  resource=true,
     *  description="Update an existing customer",
     *  headers={
     *         {
     *             "name"="X-AUTH-TOKEN",
     *             "description"="Authorization token",
     *             "required"="true"
     *         }
     *     },
     * )
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $customerBefore = $em->getRepository('AppBundle:Customer')->find($id);

        $form = $this->createForm(CustomerType::class, $customerBefore);

        $customer = json_decode($request->getContent(), true);
        $customer['birth_date'] = new \DateTime($customer['birth_date']);

        $form->submit($customer);
        $em->flush();

        return new Response('Update succeeds', Response::HTTP_OK);
    }




}
