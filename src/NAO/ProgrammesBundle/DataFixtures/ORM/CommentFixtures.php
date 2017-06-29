<?php
// src/NAO/ProgrammesBundle/DataFixtures/ORM/CommentFixtures.php

namespace NAO\ProgrammesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NAO\ProgrammesBundle\Entity\Comment;

class CommentFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $comment = new Comment();
        $comment->setUser('Jeannot');
        $comment->setComment('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut velocity magna. Etiam vehicula nunc non leo hendrerit commodo.');
        $comment->setBlog($manager->merge($this->getReference('blog-1')));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('Ludo');
        $comment->setComment('Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque !');
        $comment->setBlog($manager->merge($this->getReference('blog-1')));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('Jacqueline');
        $comment->setComment('Lorem ipsum dolor sit amet, consectetur adipiscing elittibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque.');
        $comment->setBlog($manager->merge($this->getReference('blog-2')));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('Bernard');
        $comment->setComment('Lorem ipsum dolor sit amet, consectetur adipiscing elittibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque ? ');
        $comment->setBlog($manager->merge($this->getReference('blog-2')));
        $comment->setCreated(new \DateTime("2016-07-23 06:15:20"));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('Dadou');
        $comment->setComment('Lorem ipsum dolor sit amet.');
        $comment->setBlog($manager->merge($this->getReference('blog-2')));
        $comment->setCreated(new \DateTime("2016-07-23 06:18:35"));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('Katy');
        $comment->setComment('Lorem ipsum dolor sit amet. Vestibulum vulputate mauris !');
        $comment->setBlog($manager->merge($this->getReference('blog-2')));
        $comment->setCreated(new \DateTime("2016-07-23 06:22:53"));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('Dany');
        $comment->setComment('Lorem ipsum dolor sit amet ????');
        $comment->setBlog($manager->merge($this->getReference('blog-2')));
        $comment->setCreated(new \DateTime("2016-07-23 06:25:15"));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('Loulou');
        $comment->setComment('Vestibulum vulputate mauris...');
        $comment->setBlog($manager->merge($this->getReference('blog-2')));
        $comment->setCreated(new \DateTime("2016-07-23 06:46:08"));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('Loic');
        $comment->setComment('Lorem ipsum dolor sit amet ?');
        $comment->setBlog($manager->merge($this->getReference('blog-2')));
        $comment->setCreated(new \DateTime("2016-07-23 10:22:46"));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('Kate');
        $comment->setComment('Vestibulum vulputate mauris !');
        $comment->setBlog($manager->merge($this->getReference('blog-2')));
        $comment->setCreated(new \DateTime("2016-07-23 11:08:08"));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('Doudou');
        $comment->setComment('Lorem ipsum dolor sit amet ! Vestibulum vulputate mauris ?');
        $comment->setBlog($manager->merge($this->getReference('blog-2')));
        $comment->setCreated(new \DateTime("2016-07-24 18:56:01"));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('Kate');
        $comment->setComment('Vestibulum vulputate mauris !');
        $comment->setBlog($manager->merge($this->getReference('blog-2')));
        $comment->setCreated(new \DateTime("2016-07-25 22:28:42"));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('Bruno');
        $comment->setComment('Vestibulum vulputate mauris !!! Lorem ipsum dolor sit amet.');
        $comment->setBlog($manager->merge($this->getReference('blog-3')));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('Gabriel');
        $comment->setComment('Lorem ipsum dolor sit amet. Vestibulum vulputate mauris ?');
        $comment->setBlog($manager->merge($this->getReference('blog-3')));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('Mike');
        $comment->setComment('Lorem ipsum dolor sit amet, Vestibulum vulputate mauris ?');
        $comment->setBlog($manager->merge($this->getReference('blog-5')));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('Hary');
        $comment->setComment('Lorem ipsum dolor sit amet ?');
        $comment->setBlog($manager->merge($this->getReference('blog-5')));
        $manager->persist($comment);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}