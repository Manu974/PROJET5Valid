<?php

namespace NAO\FaqBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * BlogRepository
 *
 */
class FaqRepository extends EntityRepository
{
    public function getArticleOrderedByCreated($page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('b')
            ->select('b')
            ->addOrderBy('b.created', 'DESC')
            ->getQuery()
        ;

        $query
            // On définit l'annonce à partir de laquelle commencer la liste
            ->setFirstResult(($page-1)*$nbPerPage)
            // Ainsi que le nombre d'annonce à afficher sur une page
            ->setMaxResults($nbPerPage)
        ;

        // On retourne l'objet Paginator correspondant à la requête construite
        return new Paginator($query, true);
    }
}