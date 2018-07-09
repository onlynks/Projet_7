<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;
use AppBundle\Entity\User;

class UserController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        /*$token = $request->headers->get('X-AUTH-TOKEN');

        if(!$token)
        {
            return new Response('Pas de token valide.');
        }

        $client = new Client([
            'base_uri'=>'https://graph.facebook.com/me?access_token='.$token
        ]);

        $response = $client->request('GET');

        return new Response($response->getBody()->getContents());*/
        $user = $this->getUser();

        return new Response('');
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


        return new Response('');
    }
}
