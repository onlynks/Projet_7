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

    public function validateObject($object)
    {
        $errors = $this->validator->validate($object);

        if (count($errors) > 0)
        {
            $errorsString = (string) $errors;
            return new Response($errorsString);
        }

        return null;
    }
}