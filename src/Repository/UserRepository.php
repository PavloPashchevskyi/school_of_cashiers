<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getUserInfo(User $user)
    {
        $result = $this->createQueryBuilder('u')
            ->where('u.id = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getArrayResult();

        return $result[0] ? $result[0] : [];
    }

    /**
     * @return array|int|string
     */
    public function getAllUsersList()
    {
        return $this->createQueryBuilder('u')->getQuery()->getArrayResult();
    }

    /**
     * @param User $entity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function store(User $entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }
}
