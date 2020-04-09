<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $user = new Users();
        $user->setNom('Thiam');
        $user->setPrenom('Momath');
        $user->setSexe(1);
        $user->setUsername('Smartbergerie');
        $user->setTelephone('775087104');
        $user->setEmail('smartbergerie@gmail.com');
        $user->setIsActive(true);
        $user->setPassword($this->encoder->encodePassword($user, 'Corporation2019'));
        $user->addRole('ROLE_SUPER_ADMIN');
        $manager->persist($user);
        $manager->flush();
    }
}
