<?php

namespace App\Repository;
use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\Livre;
use App\Entity\Auteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livre>
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }
    public function findByPrixSup(float $x): array {
        $dql = "SELECT l FROM App\Entity\Livre l 
            WHERE l.prix > :x";
     
     
        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter('x', $x)
            ->getResult();
     }
     
     /*public function findByPrixPages(float $x, int $y): array {
        $dql = "SELECT l FROM App\Entity\Livre l 
            WHERE l.prix > :x 
            AND l.nbPages < :y";
     
     
        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameters(['x' => $x, 'y' => $y])
            ->getResult();
     }*/
     public function findByPrixPages($x, $y)
     {
         return $this->createQueryBuilder('l')
                     ->andWhere('l.prix > :prix')
                     ->andWhere('l.nbPages < :pages')
                     ->setParameter('prix', $x)
                     ->setParameter('pages', $y)
                     ->getQuery()
                     ->getResult();
     }

     public function findByPrixPages10(float $x, int $y): array {
        return $this->createQueryBuilder('l')
            ->where('l.prix > :prix AND l.nbPages < :nbPages')
            ->setParameter('prix', $x)
            ->setParameter('nbPages', $y)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    
        }

        /*
        public function findByPrixPagesTrie(float $x, int $y): array {
            $dql = "SELECT l FROM App\Entity\Livre l 
                WHERE l.prix > :x 
                AND l.nbPages < :y 
                ORDER BY l.prix DESC";
         
         
            return $this->getEntityManager()
                ->createQuery($dql)
                ->setParameters(['x' => $x, 'y' => $y])
                ->getResult();
         }*/
         public function findByPrixPagesTrie(float $x, int $y): array {
            return $this->createQueryBuilder('l')
                ->where('l.prix > :x AND l.nbPages < :y')
                ->setParameter('x' , $x)
                ->setParameter('y' , $y)
                ->orderBy('l.prix', 'DESC')
                ->getQuery()
                ->getResult();
         }
         
         public function findByPrixPages10Trie(float $x, int $y): array {
            $dql = "SELECT l FROM App\Entity\Livre l 
                    WHERE l.prix > :x 
                    AND l.nbPages < :y 
                    ORDER BY l.prix DESC";
         
         
            return $this->getEntityManager()
                ->createQuery($dql)
                ->setParameters(['x' => $x, 'y' => $y])
                ->setMaxResults(10)
                ->getResult();
         }

         public function findByPrixPagesAuteurTrie(float $x, int $y): array {
            return $this->createQueryBuilder('l')
                ->andWhere('l.prix > :x')
                ->andWhere('l.nbPages < :y')
                ->andWhere(':auteur MEMBER OF l.auteurs')
                ->orderBy('l.prix', 'DESC')
                ->setParameter('x' , $x)
                ->setParameter('y' , $y)
                ->setParameter('x' , $x)
                ->setParameter('auteur' , $this->getEntityManager()
                        ->getRepository(Auteur::class)
                        ->findOneBy(['nom' => 'Potencier', 'prenom' => 'Fabien'])
                )
                ->getQuery()
                ->getResult();
        }
/*
         public function findByPrixPagesAuteurTrie(float $x, int $y): array {
            $dql = "SELECT l FROM App\Entity\Livre l 
                    WHERE l.prix > :x 
                    AND l.nbPages < :y 
                    AND :auteur MEMBER OF l.auteurs 
                    ORDER BY l.prix DESC";
            $auteur = $this->getEntityManager()
                ->getRepository(Auteur::class)
                ->findOneBy(['nom' => 'Potencier', 'prenom' => 'Fabien']);
        
            if (!$auteur) {
                throw new \RuntimeException('Auteur non trouvé');
            }
        
            return $this->getEntityManager()
                ->createQuery($dql)
                ->setParameters([
                    'x' => $x,
                    'y' => $y,
                    'auteur' => $auteur
                ])
                ->getResult();
        }*/
         
         
         
         

     
}
