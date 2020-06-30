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
        $testValue = new Test();
        $testValue->setName('валюта');
        $testValue->setMaxTime(1800);

        $this->addReference('test-value', $testValue);
        $manager->persist($testValue);

        $testSB = new Test();
        $testSB->setName('СБ');
        $testSB->setMaxTime(1800);

        $this->addReference('test-sb', $testSB);
        $manager->persist($testSB);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
