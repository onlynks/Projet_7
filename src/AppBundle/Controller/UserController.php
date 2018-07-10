<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use GuzzleHttp\Client;
use AppBundle\Entity\User;

class UserController extends Controller
{

    /**
     * @Route("/testCode", name="testCode")
     */
    public function testCodeAction(Request $request)
    {
        $code = $request->headers->get('code');
        $url = $request->headers->get('url');

        $codeManager = $this->container->get('CodeManager');
        $token = $codeManager->seekToken($code, $url);

        return new Response($token);
    }

    /**
     * @Route("/testToken", name="testToken")
     * @Security("has_role('ROLE_USER')")
     */
    public function testTokenAction()
    {
        $username = $this->getUser()->getUsername();
        return new Response($username);
    }

    /**
     * @Route("/createUser", name="create_user")
     */
    public function createUserAction()
    {
       /*$em = $this->getDoctrine()->getManager();

       $user = new User('Nicolas Garnier', 10215328352273615, ['ROLE_USER']);
       $em->persist($user);
       $em->flush();
       return new Response('done');
        */
    }

    public function deleteUserAction()
    {}

    public function listUserAction()
    {}


}
