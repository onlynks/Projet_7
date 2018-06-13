<?php

namespace AppBundle\Controller;

use AppBundle\Form\PhoneType;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class BileMoController extends Controller
{
    /**
     * @Route("/phone", name="create_phone")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return Response
     */
    public function createPhoneAction(Request $request)
    {
        $data = $request->getContent();
        $phone = $this->get('jms_serializer')->deserialize($data, 'AppBundle\Entity\Phone', 'json');
        $em = $this->getDoctrine()->getManager();
        $em->persist($phone);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @Route("/phone/{id}", name="read_phone")
     * @Method({"GET"})
     *
     * @param $id
     * @return Response
     */
    public function readPhoneAction($id)
    {
        $phone = $this->getDoctrine()->getRepository('AppBundle:Phone')->find($id);
        $data = $this->get('jms_serializer')->serialize($phone, 'json');

        if (empty($phone)) {
            return new Response('Phone not found', Response::HTTP_NOT_FOUND);
        }

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/phone/{id}", name="update_phone")
     * @Method({"PUT"})
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function updatePhoneAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $phoneBefore = $em->getRepository('AppBundle:Phone')->find($id);

        $form = $this->createForm(PhoneType::class, $phoneBefore);

        $data = $request->getContent();
        $phone = json_decode($data, true);

        $form->submit($phone);
        $em->flush();

        return new Response('Update succeeds');
    }

    /**
     * @Route("/phone/{id}", name="delete_phone")
     * @Method({"DELETE"})
     *
     * @param $id
     * @return Response
     */
    public function deletePhoneAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $phone = $em->getRepository('AppBundle:Phone')->find($id);

        $em->remove($phone);
        $em->flush();

        return new Response('resource deleted successfully', 202);
    }

    /**
     * @Route("/listPhone", name="list_phone")
     * @Method({"GET"})
     *
     * @param Request $request
     * @return Response
     */
    public function listPhoneAction(Request $request)
    {
        /*
        $phones = $this->getDoctrine()->getRepository('AppBundle:Phone')->findAll();

        $data = $this->get('jms_serializer')->serialize($phones, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
        */
        $order = $request->query->get('order', 'asc');
        $maxPerPage = $request->query->get('maxPerPage', 10);
        $currentPage = $request->query->get('currentPage', 1);

        $pagerFanta = $this->getDoctrine()->getRepository('AppBundle:Phone')->search($order, $maxPerPage, $currentPage);

        $data = $this->get('jms_serializer')->serialize((array)$pagerFanta->getCurrentPageResults(), 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}