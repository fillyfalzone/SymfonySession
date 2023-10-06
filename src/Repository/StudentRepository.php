<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Student>
 *
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    // public function findByStudentsNotInSession(int $id)
    // {
    //     $em = $this->getEntityManager(); // get the EntityManager
    //     $sub = $em->createQueryBuilder(); // create a new QueryBuilder

    //     $qb = $sub; // use the same QueryBuilder for the subquery

    //     $qb->select('s') // select the root alias
    //         ->from('App\Entity\Student', 's') // the subquery is based on the same entity
    //         ->leftJoin('s.session_student', 'se') // join the subquery
    //         ->where('se.id = :id');

    //     $sub = $em->createQueryBuilder(); // create a new QueryBuilder

    //     $sub->select('st')->from('App\Entity\Student', 'st')
    //         ->where($sub->expr()->notIn('st.id', $qb->getDQL()))
    //         ->setParameter('id', $id);

    //     return $sub->getQuery()->getResult();
    // }

//    /**
//     * @return Student[] Returns an array of Student objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Student
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
