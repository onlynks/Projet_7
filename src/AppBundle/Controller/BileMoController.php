<?php

namespace AppBundle\Controller;

use AppBundle\Form\PhoneType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class BileMoController extends Controller
{
    /**
     * @Route("/phone", name="create_phone")
     * @Method({"POST"})
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function createPhoneAction(Request $request)
    {
        $data = $request->getContent();
        $phone = $this->get('jms_serializer')->deserialize($data, 'AppBundle\Entity\Phone', 'json');

        $validator = $this->container->get('Validator_service');
        if ($validator->getErrors($phone)) {

            return new JsonResponse(['Error'=>$validator->getMessage($phone)], 404);
        }

        $brandName = $phone->getBrand()->getName();
        $brand = $this->getDoctrine()->getRepository('AppBundle:Brand')->findOneByname($brandName);
        $phone->setBrand($brand);
        $em = $this->getDoctrine()->getManager();

        $em->persist($phone);
        $em->flush();

        return new Response('Phone created.', 200);
    }

    /**
     * @Route("/phone/{id}", name="read_phone")
     * @Method({"GET"})
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @ApiDoc(
     *  section="Phone",
     *  resource=true,
     *  description="Get phone details",
     *  headers={
     *         {
     *             "name"="X-AUTH-TOKEN",
     *             "description"="Authorization token",
     *             "required"="true"
     *         }
     *     },
     *  requirements={
     *         {
     *             "name"="id",
     *             "dataType"="integer",
     *             "requirements"="\d+",
     *             "description"="The phone unique identifier."
     *         }
     *     }
     * )
     */
    public function readPhoneAction($id)
    {
        $phone = $this->getDoctrine()->getRepository('AppBundle:Phone')->find($id);

        if($phone == null){
            return new Response('This phone doesn\'t exist', 404);
        }

        $validator = $this->container->get('Validator_service');
        if ($validator->getErrors($phone)) {
            return new JsonResponse(['Status'=>'This phone isn\'t available.', 'Error'=>$validator->getMessage($phone)], 404);
        }

        $data = $this->get('jms_serializer')->serialize($phone, 'json');

        $response = new Response($data, 200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/phone/{id}", name="update_phone")
     * @Method({"PUT"})
     *
     *@Security("has_role('ROLE_ADMIN')")
     */
    public function updatePhoneAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $phoneBefore = $em->getRepository('AppBundle:Phone')->find($id);

        if($phoneBefore == null){
            return new Response('This phone doesn\'t exist', 404);
        }

        $form = $this->createForm(PhoneType::class, $phoneBefore);

        $data = $request->getContent();
        $phone = json_decode($data, true);

        $form->submit($phone);
        $em->flush();

        return new Response('Update succeeds', 200);
    }

    /**
     * @Route("/phone/{id}", name="delete_phone")
     * @Method({"DELETE"})
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deletePhoneAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $phone = $em->getRepository('AppBundle:Phone')->find($id);

        if($phone == null){
            return new Response('This phone doesn\'t exist', 404);
        }

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
     * @ApiDoc(
     *  section="Phone",
     *  resource=true,
     *  description="Get a phone list depending of parameters.",
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
    public function listPhoneAction(Request $request)
    {
        $order = $request->query->get('order', 'asc');
        $maxPerPage = $request->query->get('maxPerPage', 10);
        $currentPage = $request->query->get('currentPage', 1);

        $pagerFanta = $this->getDoctrine()->getRepository('AppBundle:Phone')->search($order, $maxPerPage, $currentPage);

        $data = $this->get('jms_serializer')->serialize((array)$pagerFanta->getCurrentPageResults(), 'json', SerializationContext::create()->setGroups(array('list')));
        $response = new Response($data, 200);
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

        return new Response('Image created', 201);
    }
}
