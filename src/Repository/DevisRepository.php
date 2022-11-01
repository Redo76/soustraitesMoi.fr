<?php

namespace App\Repository;

use App\Entity\Devis;
use App\Entity\Image;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Devis>
 *
 * @method Devis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Devis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Devis[]    findAll()
 * @method Devis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Devis::class);
    }

    public function save(Devis $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Devis $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByDevisId(int $id)
    {
          // :id en gros = à id dans url. Et dans execute query () :id = $id
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT * FROM devis d
            WHERE id = :id
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);

        return $resultSet->fetchAssociative();
    }



    // test devis
    public function tousDevis()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT * FROM `devis` ORDER BY id DESC;";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    // test afficher devis uploadé
    public function findByDevisUpload(int $id)
    {
        // :id en gros = à id dans url. Et dans execute query () :id = $id
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT name FROM image i
            WHERE devis_id = :id
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);

        return $resultSet->fetchAssociative();
    }

}