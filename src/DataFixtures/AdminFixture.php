<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminFixture extends Fixture
{
    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $adminM = new Admin();
        $adminM->setEmail('mariya@example.com');
        $adminM->setName('Mariya');
        $adminM->setPhone('+380661234567');
        $adminM->setPassword($this->passwordEncoder->encodePassword($adminM, '12345678'));
        $adminM->setRoles(['ROLE_ADMIN', 'ROLE_USER']);

        $this->addReference('admin-mariya', $adminM);
        $manager->persist($adminM);

        $adminA = new Admin();
        $adminA->setEmail('alla@example.com');
        $adminA->setName('Alla');
        $adminA->setPhone('+380661234568');
        $adminA->setPassword($this->passwordEncoder->encodePassword($adminA, '23456789'));
        $adminA->setRoles(['ROLE_ADMIN', 'ROLE_USER']);

        $this->addReference('admin-alla', $adminA);
        $manager->persist($adminA);

        $adminE = new Admin();
        $adminE->setEmail('eugenia@example.com');
        $adminE->setName('Eugenia');
        $adminE->setPhone('+380661234569');
        $adminE->setPassword($this->passwordEncoder->encodePassword($adminE, '34567890'));
        $adminE->setRoles(['ROLE_ADMIN', 'ROLE_USER']);

        $this->addReference('admin-eugenia', $adminE);
        $manager->persist($adminE);

        $manager->flush();
    }
}
