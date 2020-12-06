<?php

namespace App\Tests;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testSomething()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        /** @var EntityManagerInterface $entityManager */
        $entityManager = static::$kernel->getContainer()->get('doctrine')->getManager();
        $repository = $entityManager->getRepository(User::class);

        $this->assertResponseIsSuccessful();

        /** @var User $user */
        $user = $repository->findOneBy([]);
        $this->assertEquals('test@mail.com', $user->getEmail());
    }
}
