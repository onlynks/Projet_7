<?php

namespace AppBundle\Controller;

use AppBundle\Form\PhoneType;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use JMS\Serializer\SerializationContext;

class BileMoController extends Controller
{
    /**
     * @Route("/phone", name="create_phone")
     * @Method({"POST"})
     *
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param Request $request
     * @return Response
     */
    public function createPhoneAction(Request $request)
    {
        $data = $request->getContent();
        $phone = $this->get('jms_serializer')->deserialize($data, 'AppBundle\Entity\Phone', 'json');
        $brandName = $phone->getBrand()->getName();
        $brand = $this->getDoctrine()->getRepository('AppBundle:Brand')->findOneByname($brandName);
        $phone->setBrand($brand);
        $em = $this->getDoctrine()->getManager();
        $em->persist($phone);
        $em->flush();

        return new Response('Nouveau téléphone créé.', Response::HTTP_CREATED);
    }

    /**
     * @Route("/phone/{id}", name="read_phone")
     * @Method({"GET"})
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @param $id
     * @return Response
     */
    public function readPhoneAction($id)
    {
        $phone = $this->getDoctrine()->getRepository('AppBundle:Phone')->find($id);

        $validator = $this->container->get('Validator_service');
        if($validator->getErrors($phone))
        {
            return $validator->getMessage($phone);
        }

        $data = $this->get('jms_serializer')->serialize($phone, 'json');

        if (empty($phone)) {
            return new Response('Phone not found', Response::HTTP_NOT_FOUND);
        }

        $response = new Response($data, Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/phone/{id}", name="update_phone")
     * @Method({"PUT"})
     *
     *@Security("has_role('ROLE_ADMIN')")
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

        return new Response('Update succeeds', Response::HTTP_OK);
    }

    /**
     * @Route("/phone/{id}", name="delete_phone")
     * @Method({"DELETE"})
     *
     * @Security("has_role('ROLE_ADMIN')")
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
     * @Route("/phone", name="list_phone")
     * @Method({"GET"})
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @param Request $request
     * @return Response
     */
    public function listPhoneAction(Request $request)
    {
        $order = $request->query->get('order', 'asc');
        $maxPerPage = $request->query->get('maxPerPage', 10);
        $currentPage = $request->query->get('currentPage', 1);

        $pagerFanta = $this->getDoctrine()->getRepository('AppBundle:Phone')->search($order, $maxPerPage, $currentPage);

        $data = $this->get('jms_serializer')->serialize((array)$pagerFanta->getCurrentPageResults(), 'json', SerializationContext::create()->setGroups(array('list')));
        $response = new Response($data, Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/setImage/{id}", name="set_image")
     * @Method({"POST"})
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function setImageAction(Request $request, $id)
    {
        $path = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();

        $data = $request->getContent();
        $photo = $this->get('jms_serializer')->deserialize($data, 'AppBundle\Entity\Photo', 'json');

        $photo->setName($path.'/Images/'.$photo->getName());

        $phone = $this->getDoctrine()->getRepository('AppBundle:Phone')->find($id);
        $phone->getPhoto()->add($photo);

        $em = $this->getDoctrine()->getManager();
        $em->persist($phone);
        $em->flush();

        return new Response('Image créé', Response::HTTP_CREATED);
    }

}
