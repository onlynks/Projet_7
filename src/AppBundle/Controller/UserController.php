<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;

class UserController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $token = $request->headers->get('X-AUTH-TOKEN');

        $client = new Client([
            'base_uri'=>'https://graph.facebook.com/me?access_token='.$token
        ]);

        $response = $client->request('GET');

        return new Response($response->getBody()->getContents());
    }

    public function createUserAction()
    {}

    public function readPUserAction()
    {}

    public function updateUserAction()
    {}

    public function deleteUserAction()
    {}

    public function listUserAction()
    {}

    /**
     * @Route("/test", name="test")
     */
    public function testAction(Request $request)
    {

        $test = $request->headers->get('test');
var_dump($test);
        return new Response($test);
    }
}
