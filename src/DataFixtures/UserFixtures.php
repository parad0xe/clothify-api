<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const APP_USER_REFERENCE = "app-user";

    public function __construct(private readonly UserPasswordHasherInterface $hasher) { }

    public function load(ObjectManager $manager): void
    {
        $user = (new User())
            ->setUsername("john")
            ->setFirstname("john")
            ->setLastname("doe")
            ->setEmail("app@demo.com");

        $user->setPassword(
            $this->hasher->hashPassword($user, "app")
        );

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::APP_USER_REFERENCE, $user);
    }
}
