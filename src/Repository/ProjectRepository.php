<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Project>
 *
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function add(Project $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Project $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // LIER USER/PROJECT:
    // utiliser la fonction findBy
    // quand je rappellerai la fonction dans le Projectcontroller, le paramètre $value deviendra $user

    public function findAllValidProjects(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT * FROM (SELECT id, nom_du_projet , type, created_at, user_id , statut, price FROM `project` UNION SELECT id, nom_du_projet , type, created_at, user_id, statut, price FROM `project_logo` UNION SELECT id, nom_du_projet , type, created_at, user_id, statut, price FROM `project_reseaux` UNION SELECT id, nom_du_projet , type, created_at, user_id, statut, price FROM `project_site`) AS p WHERE p.statut = true ORDER BY p.created_at DESC";
    
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function searchValidProjects($mots)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT * FROM (SELECT id, nom_du_projet , type, created_at, user_id , statut, price FROM `project` UNION SELECT id, nom_du_projet , type, created_at, user_id, statut, price FROM `project_logo` UNION SELECT id, nom_du_projet , type, created_at, user_id, statut, price FROM `project_reseaux` UNION SELECT id, nom_du_projet , type, created_at, user_id, statut, price FROM `project_site`) AS p WHERE p.statut = true AND p.nom_du_projet LIKE '%" . $mots . "%' ORDER BY p.created_at DESC";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function findAllProjects(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT * FROM (SELECT id, nom_du_projet , type, created_at, user_id , statut, price FROM `project` UNION SELECT id, nom_du_projet , type, created_at, user_id, statut, price FROM `project_logo` UNION SELECT id, nom_du_projet , type, created_at, user_id, statut, price FROM `project_reseaux` UNION SELECT id, nom_du_projet , type, created_at, user_id, statut, price FROM `project_site`) AS p WHERE p.statut = false ORDER BY p.created_at DESC";
    
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
    public function searchAllProjects($mots)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT * FROM (SELECT id, nom_du_projet , type, created_at, user_id , statut, price FROM `project` UNION SELECT id, nom_du_projet , type, created_at, user_id, statut, price FROM `project_logo` UNION SELECT id, nom_du_projet , type, created_at, user_id, statut, price FROM `project_reseaux` UNION SELECT id, nom_du_projet , type, created_at, user_id, statut, price FROM `project_site`) AS p WHERE p.statut = false AND p.nom_du_projet LIKE '%" . $mots . "%' ORDER BY p.created_at DESC";
    
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function findAllInProgressProjects(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT * FROM (SELECT id, nom_du_projet , type, created_at, user_id , statut, price FROM `project` UNION SELECT id, nom_du_projet , type, created_at, user_id, statut, price FROM `project_logo` UNION SELECT id, nom_du_projet , type, created_at, user_id, statut, price FROM `project_reseaux` UNION SELECT id, nom_du_projet , type, created_at, user_id, statut, price FROM `project_site`) AS p WHERE p.statut IS NULL ORDER BY p.created_at DESC;";
    
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function searchProgressProjects($mots)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT * FROM (SELECT id, nom_du_projet , type, created_at, user_id , statut, price FROM `project` UNION SELECT id, nom_du_projet , type, created_at, user_id, statut, price FROM `project_logo` UNION SELECT id, nom_du_projet , type, created_at, user_id, statut, price FROM `project_reseaux` UNION SELECT id, nom_du_projet , type, created_at, user_id, statut, price FROM `project_site`) AS p WHERE p.statut IS NULL AND p.nom_du_projet LIKE '%" . $mots . "%' ORDER BY p.created_at DESC;";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
//    /**
//     * @return Project[] Returns an array of Project objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Project
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
