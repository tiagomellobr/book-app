<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}
    
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('user@mail.com');
        $user->setRoles(['ROLE_USER']);
        $hash = $this->passwordHasher->hashPassword($user, 'pass1234');
        $user->setPassword($hash);
        
        $manager->persist($user);
        $manager->flush();
    }
}
