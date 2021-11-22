<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Security;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{

    private $tokenStorage;
    private $security;

    public function __construct(ManagerRegistry $registry, TokenStorageInterface $tokenStorage, Security $security)
    {
        parent::__construct($registry, Task::class);
        $this->tokenStorage = $tokenStorage;
        $this->security = $security;
    }

    public function findAllForCurrentUser($isDone = null)
    {
        $q = $this->createQueryBuilder('t')
            ->orderBy('t.id', 'DESC');
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            $q->where('t.createdBy = :user')
                ->setParameter('user', $this->tokenStorage->getToken()->getUser());
        }

        if ($isDone !== null) {
            $q->andWhere('t.isDone = :isDone')->setParameter('isDone', $isDone);
        }

        return $q
            ->getQuery()
            ->getResult();
    }
}
