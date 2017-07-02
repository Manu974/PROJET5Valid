<?php
// src/NAO/ProgrammesBundle/Repository/CommentRepository.php

namespace NAO\ProgrammesBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CommentRepository
 */
class CommentRepository extends EntityRepository
{
    public function getCommentsForBlog($blogId)
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.blog = :blog_id')
            ->addOrderBy('c.id')
            ->addOrderBy('c.created')
            ->setParameter('blog_id', $blogId);

        return $qb->getQuery()->getResult();
    }

    public function getAdminCommentsForBlog($blogId)
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.blog = :blog_id')
            ->addOrderBy('c.reported', 'DESC')
            ->addOrderBy('c.id')
            ->addOrderBy('c.created')
            ->setParameter('blog_id', $blogId);

        return $qb->getQuery()->getResult();
    }

    public function getLatestComments($limit = 10)
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c')
            ->addOrderBy('c.id', 'DESC');

        if (false === is_null($limit))
            $qb->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }
}