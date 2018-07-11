<?php

namespace AppBundle\Service;
use Symfony\Component\HttpFoundation\Response;

class Validator
{
    private $validator;

    public function __construct($validator)
    {
        $this->validator = $validator;
    }

    public function getErrors($object)
    {
        $errors = $this->validator->validate($object);
        return $response = (count($errors) > 0)?true:false;
    }

    public function getMessage($object)
    {
        $errors = $this->validator->validate($object);

        $errorsString = (string) $errors;
        return new Response($errorsString);
    }
}