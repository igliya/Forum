<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Section;
use App\Entity\Topic;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->passwordEncoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // create users
        // create user1
        $user1 = new User();
        $user1->setPassword($this->passwordEncoder->encodePassword($user1, 'User1!123'));
        $user1->setEmail('user1@example.com');
        $user1->setName('Пользователь 1');
        $manager->persist($user1);
        // create user2
        $user2 = new User();
        $user2->setPassword($this->passwordEncoder->encodePassword($user2, 'User2!123'));
        $user2->setEmail('user2@example.com');
        $user2->setName('Пользователь 2');
        $manager->persist($user2);
        // create admin
        $admin = new User();
        $admin->setPassword($this->passwordEncoder->encodePassword($admin, 'Admin123!'));
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setEmail('admin@example.com');
        $admin->setName('Администратор');
        $manager->persist($admin);
        // create sections
        $sections = ['animals' => 'Животные', 'books' => 'Книги', 'medicine' => 'Медицина', 'sport' => 'Спорт',
            'tv-and-cinema' => 'ТВ и кино', 'photos' => 'Фото', 'computer-science' => 'Компьютерные технологии'];
        foreach ($sections as $code => $name) {
            $section = new Section();
            $section->setCode($code);
            $section->setName($name);
            $manager->persist($section);
            $topic = new Topic();
            $topic->setSection($section);
            $topic->setAuthor($admin);
            $topic->setTitle('Правила оформления топиков');
            $topic->setText('Правила оформления топиков');
            $manager->persist($topic);
            // first comment
            $comment1 = new Comment();
            $comment1->setTopic($topic);
            $comment1->setAuthor($user1);
            $comment1->setText('Хорошие правила');
            $manager->persist($comment1);
            // second comment
            $comment2 = new Comment();
            $comment2->setTopic($topic);
            $comment2->setAuthor($user2);
            $comment2->setText('Полностью согласен с правилами!');
            $manager->persist($comment2);
        }
        $manager->flush();
    }
}
