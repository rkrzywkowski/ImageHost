<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFitures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
       $user = new User();
       $user->setUsername('admin');
       $user->setEmail('admin@localhost.local');
       $user->setRoles(['ROLE_USER']);
       $user->setPassword($this->passwordEncoder->encodePassword($user, 'strefakursow'));
       $manager->persist($user);
       $manager->flush();
    }
}
