<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    )
    {

    }

    public function load(ObjectManager $manager): void
    {


//        $microPost = new MicroPost();
//        $microPost->setTitle("This is mi frist text");
//        $microPost->setText("lorem impsum");
//        $microPost->setDate(new DateTime());
//        $manager->persist($microPost);
//
//        $manager->flush();
    }
}
