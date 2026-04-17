<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const JOHN_REF = 'user-john';
    public const JANE_REF = 'user-jane';

    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $john = new User();
        $john->setEmail('john.doe@gmail.com');
        $john->setFirstname('John');
        $john->setLastname('Doe');
        $john->setRoles(['ROLE_CONNECTED_USER']);
        $john->setInscriptionDate(new \DateTime('2026-04-17'));
        $john->setIsVerified(true);
        $john->setPassword($this->hasher->hashPassword($john, 'password'));
        $manager->persist($john);
        $this->addReference(self::JOHN_REF, $john);

        $jane = new User();
        $jane->setEmail('jane.doe@mail.com');
        $jane->setFirstname('Jane');
        $jane->setLastname('Doe');
        $jane->setRoles(['ROLE_CONNECTED_USER']);
        $jane->setInscriptionDate(new \DateTime('2026-04-17'));
        $jane->setIsVerified(true);
        $jane->setPassword($this->hasher->hashPassword($jane, 'password'));
        $manager->persist($jane);
        $this->addReference(self::JANE_REF, $jane);

        $manager->flush();
    }
}