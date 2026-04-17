<?php

namespace App\DataFixtures;

use App\Entity\Announcement;
use App\Enum\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AnnouncementFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var \App\Entity\User $john */
        $john = $this->getReference(UserFixtures::JOHN_REF, \App\Entity\User::class);
        /** @var \App\Entity\User $jane */
        $jane = $this->getReference(UserFixtures::JANE_REF, \App\Entity\User::class);

        $wii = new Announcement();
        $wii->setTitle('Wii');
        $wii->setDescription("Console Nintendo Wii en bon état de fonctionnement...");
        $wii->setcategory(Category::Consoles);
        $wii->setDate(new \DateTime('2026-04-17 12:38:07'));
        $wii->setUpdatedAt(new \DateTimeImmutable('2026-04-17 12:38:07'));
        $wii->setAuthorId($john);
        $wii->setImageName("wii-69e229af679fe546230597.jpg");
        $manager->persist($wii);

        $pokemon = new Announcement();
        $pokemon->setTitle('Pokemon feu gameboy');
        $pokemon->setDescription("Cartouche Pokémon Version Rouge pour Game Boy classique...");
        $pokemon->setcategory(Category::Jeux);
        $pokemon->setDate(new \DateTime('2026-04-17 12:41:25'));
        $pokemon->setUpdatedAt(new \DateTimeImmutable('2026-04-17 12:41:25'));
        $pokemon->setAuthorId($john);
        $pokemon->setImageName("pokemon-feu-gameboy-69e22a7524270926568961.jpg");
        $manager->persist($pokemon);

        $manette = new Announcement();
        $manette->setTitle('Manette Xbox');
        $manette->setDescription("Manette Xbox en très bon état...");
        $manette->setcategory(Category::Accessoires);
        $manette->setDate(new \DateTime('2026-04-17 12:45:11'));
        $manette->setUpdatedAt(new \DateTimeImmutable('2026-04-17 12:45:11'));
        $manette->setImageName("manette-xbox-69e22b57cf510491458506.jpg");
        $manette->setAuthorId($jane);

        $manette->addInterestedUserId($john);

        $manager->persist($manette);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }
}