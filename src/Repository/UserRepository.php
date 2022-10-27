<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->add($user, true);
    }

    public function findAllProjectsByUserId($id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT * FROM (SELECT id, nom_du_projet , type, created_at, user_id , statut FROM `project` UNION SELECT id, nom_du_projet , type, created_at, user_id, statut FROM `project_logo` UNION SELECT id, nom_du_projet , type, created_at, user_id, statut FROM `project_reseaux` UNION SELECT id, nom_du_projet , type, created_at, user_id, statut FROM `project_site`) AS p WHERE p.user_id = :id ORDER BY p.created_at DESC";
    
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(["id" => $id]);
        
        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function findAllDevisByUserId($id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT * FROM `devis` AS d WHERE d.user_id = :id ORDER BY d.created_at DESC";
    
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(["id" => $id]);
        
        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
    
    public function findUserById($id): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findUsersByRole($role): array
    {
        // return $this->createQueryBuilder('u')
        //     ->andWhere('u.roles = :val')
        //     ->setParameter('val', $roles)
        //     ->orderBy('u.id', 'ASC')
        //     ->setMaxResults(10)
        //     ->getQuery()
        //     ->getResult()
        // ;
        return $this->createQueryBuilder('u')
        ->andWhere('u.roles LIKE :role')
        ->setParameter('role', '%'.$role.'%')
        ->getQuery()
        ->getResult();
    }

}
