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
        $testValue->setType('currency');
        $testValue->setMaxTime(3600);

        $this->addReference('test-value', $testValue);
        $manager->persist($testValue);

        $testSB = new Test();
        $testSB->setName('СБ');
        $testSB->setType('secure');
        $testSB->setMaxTime(3600);

        $this->addReference('test-sb', $testSB);
        $manager->persist($testSB);

        $testBank = new Test();
        $testBank->setName('НБУ');
        $testBank->setType('bank');
        $testBank->setMaxTime(3600);
        
        $this->addReference('test-bank', $testBank);
        $manager->persist($testBank);
        
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
