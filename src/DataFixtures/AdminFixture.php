<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminFixture extends Fixture implements FixtureGroupInterface
{
    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin1 = new Admin();
        $admin1->setEmail('m.suvorova@kitgroup.ua');
        $admin1->setName('Мария Суворова');
        $admin1->setPhone('+380504021716');
        $admin1->setPassword($this->passwordEncoder->encodePassword($admin1, '9g}6&d&]]8^nn]hoZ'));
        $admin1->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $this->addReference('admin-1', $admin1);
        $manager->persist($admin1);

        $admin2 = new Admin();
        $admin2->setEmail('l.rakcheeva@kitgroup.ua');
        $admin2->setName('Людмила Ракчеева');
        $admin2->setPhone('+380504885001');
        $admin2->setPassword($this->passwordEncoder->encodePassword($admin2, '>vYQzp5JEcb0)k$!5'));
        $admin2->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $this->addReference('admin-2', $admin2);
        $manager->persist($admin2);

        $admin3 = new Admin();
        $admin3->setEmail('e.tomilenko@kitgroup.ua');
        $admin3->setName('Евгения Томиленко');
        $admin3->setPhone('+380503473978');
        $admin3->setPassword($this->passwordEncoder->encodePassword($admin3, 'V0h7w@h0qGdSfB[sY'));
        $admin3->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $this->addReference('admin-3', $admin3);
        $manager->persist($admin3);

        $admin4 = new Admin();
        $admin4->setEmail('a.neustupova@kitgroup.ua');
        $admin4->setName('Анна Неуступова');
        $admin4->setPhone('+380504885010');
        $admin4->setPassword($this->passwordEncoder->encodePassword($admin4, "RXy'9zuSW{u.Z$+j"));
        $admin4->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $this->addReference('admin-4', $admin4);
        $manager->persist($admin4);

        $admin5 = new Admin();
        $admin5->setEmail('v.torshina@kitgroup.ua');
        $admin5->setName('Вита Торшина');
        $admin5->setPhone('+380504777435');
        $admin5->setPassword($this->passwordEncoder->encodePassword($admin5, 'u&qbMP+YX<g*7<VV'));
        $admin5->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $this->addReference('admin-5', $admin5);
        $manager->persist($admin5);

        $admin6 = new Admin();
        $admin6->setEmail('yu.drobot@kitgroup.ua');
        $admin6->setName('Юлия Дробот');
        $admin6->setPhone('+380686808268');
        $admin6->setPassword($this->passwordEncoder->encodePassword($admin6, "Kxu-'M^T_2@c[4,B"));
        $admin6->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $this->addReference('admin-6', $admin6);
        $manager->persist($admin6);

        $admin7 = new Admin();
        $admin7->setEmail('n.kovalenko@kitgroup.ua');
        $admin7->setName('Наталья Коваленко');
        $admin7->setPhone('+380502901505');
        $admin7->setPassword($this->passwordEncoder->encodePassword($admin7, 'NxS;g8nV$sTSjq"]'));
        $admin7->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $this->addReference('admin-7', $admin7);
        $manager->persist($admin7);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['AdminFixtures'];
    }
}

