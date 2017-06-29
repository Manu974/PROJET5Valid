<?php
// src/NAO/FaqBundle/DataFixtures/ORM/FaqFixtures.php

namespace NAO\FaqBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NAO\FaqBundle\Entity\Faq;

class FaqFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faq1 = new Faq();
        $faq1->setTitle('Faq 1');
        $faq1->setFaq('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut velocity magna. Etiam vehicula nunc non leo hendrerit commodo. Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras el mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras elementum molestie vestibulum. Morbi id quam nisl. Praesent hendrerit, orci sed elementum lobortis, justo mauris lacinia libero, non facilisis purus ipsum non mi. Aliquam sollicitudin, augue id vestibulum iaculis, sem lectus convallis nunc, vel scelerisque lorem tortor ac nunc. Donec pharetra eleifend enim vel porta.');
        $faq1->setAuthor('Jean Pigeon');
        $faq1->setCreated(new \DateTime());
        $faq1->setUpdated($faq1->getCreated());
        $manager->persist($faq1);

        $faq2 = new Faq();
        $faq2->setTitle('Faq 2');
        $faq2->setFaq('Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Na. Cras elementum molestie vestibulum. Morbi id quam nisl. Praesent hendrerit, orci sed elementum lobortis.');
        $faq2->setAuthor('Dominique Lemerle');
        $faq2->setCreated(new \DateTime("2016-07-23 06:12:33"));
        $faq2->setUpdated($faq2->getCreated());
        $manager->persist($faq2);

        $faq3 = new Faq();
        $faq3->setTitle('Faq 3');
        $faq3->setFaq('Lorem ipsumvehicula nunc non leo hendrerit commodo. Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque.');
        $faq3->setAuthor('Béatrice Lapie');
        $faq3->setCreated(new \DateTime("2016-07-16 16:14:06"));
        $faq3->setUpdated($faq3->getCreated());
        $manager->persist($faq3);

        $faq4 = new Faq();
        $faq4->setTitle('Faq 4');
        $faq4->setFaq('Lorem commodo. Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra.');
        $faq4->setAuthor('Bernard Moineau');
        $faq4->setCreated(new \DateTime("2016-06-02 18:54:12"));
        $faq4->setUpdated($faq4->getCreated());
        $manager->persist($faq4);

        $faq5 = new Faq();
        $faq5->setTitle('Faq 5');
        $faq5->setFaq('Lorem ipsum dolor sit amet, consectetur adipiscing elittibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque.');
        $faq5->setAuthor('Johnny Begood');
        $faq5->setCreated(new \DateTime("2016-04-25 15:34:18"));
        $faq5->setUpdated($faq5->getCreated());
        $manager->persist($faq5);

        $manager->flush();

        $this->addReference('faq-1', $faq1);
        $this->addReference('faq-2', $faq2);
        $this->addReference('faq-3', $faq3);
        $this->addReference('faq-4', $faq4);
        $this->addReference('faq-5', $faq5);
    }

    public function getOrder()
    {
        return 1;
    }

}