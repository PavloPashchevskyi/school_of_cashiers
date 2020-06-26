<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Test;

class TestFixture extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $test1 = new Test();
        $test1->setName('The first test in data fixture');
        $test1->setMaxTime(28800);

        $this->addReference('test-the-first', $test1);
        $manager->persist($test1);
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
