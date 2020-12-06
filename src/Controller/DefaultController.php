<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * DefaultController constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/default", name="default")
     */
    public function index(): Response
    {
        $repository = $this->entityManager->getRepository(User::class);
        if (!$user = $repository->findOneBy([])) {
            $user = new User();
            $user->setEmail('test@mail.com');
            $user->setPassword('secret');
            $user->setRoles(['ROLE_USER']);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'user' => $user,
        ]);
    }
}
