<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->passwordEncoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // create user
        $user = new User();
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'user123!'));
        $user->setRoles(['ROLE_USER']);
        $user->setEmail('user@example.com');
        $user->setName('Пользователь');
        $manager->persist($user);
        // create admin
        $admin = new User();
        $admin->setPassword($this->passwordEncoder->encodePassword($admin, 'admin123!'));
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setEmail('admin@example.com');
        $admin->setName('Администратор');
        $manager->persist($admin);
        // flush manager
        $manager->flush();
    }
}
