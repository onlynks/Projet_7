<?php

namespace AppBundle\Security;

use AppBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use GuzzleHttp\Client;
use JMS\Serializer\Serializer;
use Doctrine\ORM\EntityManagerInterface;

class FacebookUserProvider implements UserProviderInterface
{
    private $client;
    private $serializer;
    private $entityManager;

    public function __construct(Client $client, Serializer $serializer, EntityManagerInterface $entityManager)
    {
        $this->client = $client;
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
    }

    public function loadUserByUsername($token)
    {
        $response = $this->client->get('https://graph.facebook.com/me?access_token='.$token);

        $res = $response->getBody()->getContents();
        $userData = $this->serializer->deserialize($res, 'array', 'json');

        $user = $this->entityManager->getRepository(User::class)->findOneByfacebookId($userData['id']);

        if(!$user)
        {
            throw new UsernameNotFoundException(
                sprintf('Le token "%s" n\'existe pas.', $token));

        }
        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User)
        {
            throw new UnsupportedUserException(
            sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }
}