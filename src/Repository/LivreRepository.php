<?php

namespace App\Repository;
use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\Livre;
use App\Entity\Editeur;
use App\Entity\Categorie;
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

    // src/Repository/LivreRepository.php
    public function search(?string $titre = null, ?Editeur $editeur = null, ?Categorie $categorie = null): array
    {
        $qb = $this->createQueryBuilder('l');

        if ($titre) {
            $qb->andWhere('l.titre LIKE :titre')
                ->setParameter('titre', '%' . $titre . '%');
        }

        if ($editeur) {
            $qb->andWhere('l.editeur = :editeur')
                ->setParameter('editeur', $editeur);
        }

        if ($categorie) {
            $qb->andWhere('l.categorie = :categorie')
                ->setParameter('categorie', $categorie);
        }

        return $qb->orderBy('l.titre', 'ASC')
            ->getQuery()
            ->getResult();
    }

}
