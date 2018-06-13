<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
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

}
