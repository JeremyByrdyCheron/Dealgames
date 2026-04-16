<?php

namespace App\Repository;

use App\Entity\Announcement;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AnnouncementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Announcement::class);
    }
    public function findByInterestedUser(User $user): array
    {
        return $this->createQueryBuilder('a')
            ->join('a.InterestedUserId', 'user')
            ->where('user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
