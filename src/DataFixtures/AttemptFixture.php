<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Attempt;

class AttemptFixture extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $attempt1 = new Attempt();
        $attempt1->setUser($this->getReference('user-tsapko'));
        $attempt1->setTest($this->getReference('test-the-first'));
        $attempt1->setNumberOfPoints(12);
        $attempt1->setStartTimestamp((int) (new \DateTime())->sub(new \DateInterval('PT8H'))->format('U'));
        $attempt1->setEndTimestamp((int) (new \DateTime())->format('U'));

        $this->addReference('attempt-the-first', $attempt1);
        $manager->persist($attempt1);
        $manager->flush();

        /** @var \App\Entity\User $attemptedUser */
        $attemptedUser = $this->getReference('user-tsapko');
        $attemptedUser->addAttempt($this->getReference('attempt-the-first'));
        $manager->persist($attemptedUser);
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
