<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixture extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setName('Цапко О.Г.');
        $user1->setPhone('+380666516373');
        $user1->setEmail('hr@example.com');
        $user1->setCity('Нікополь');

        $this->addReference('user-tsapko', $user1);
        $manager->persist($user1);
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
