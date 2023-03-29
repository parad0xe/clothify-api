<?php

namespace App\DataFixtures;

use App\Entity\Cart;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CartFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
//        /** @var User $user */
//        $user = $this->getReference(UserFixtures::APP_USER_REFERENCE);
//
//        $cart = (new Cart())
//            ->setUser($user)
//            ->setDiscountPercentage(0);
//
//        $manager->persist($cart);
//        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            UserFixtures::class
        ];
    }
}
