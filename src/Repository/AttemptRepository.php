<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Attempt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Attempt|null find($id, $lockMode = null, $lockVersion = null)
 * @method Attempt|null findOneBy(array $criteria, array $orderBy = null)
 * @method Attempt[]    findAll()
 * @method Attempt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttemptRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attempt::class);
    }

    public function getUsersAttempts(): array
    {
        $sql = "
            SELECT u.name, u.city, u.email, u.phone, t.name, a.start_timestamp, a.end_timestamp, a.number_of_points
            FROM user u
            JOIN attempt a ON (a.user_id = u.id)
            JOIN test t ON(a.test_id = t.id)
            ";

        $query = $this->getEntityManager()->getConnection()->query($sql);

        return $query->fetchAll();
    }
}
