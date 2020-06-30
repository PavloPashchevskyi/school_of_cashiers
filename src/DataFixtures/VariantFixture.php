<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Variant;

class VariantFixture extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $variant1Euro = new Variant();
        $variant1Euro->setText('1 евро');
        $variant1Euro->setValue(0);
        $variant1Euro->setQuestion($this->getReference('question-1'));
        $this->addReference('variant-1-euro', $variant1Euro);
        $manager->persist($variant1Euro);

        $variant5Euros = new Variant();
        $variant5Euros->setText('5 евро');
        $variant5Euros->setValue(1);
        $variant5Euros->setQuestion($this->getReference('question-1'));
        $this->addReference('variant-5-euros', $variant5Euros);
        $manager->persist($variant5Euros);

        $variant2Euros = new Variant();
        $variant2Euros->setText('2 евро');
        $variant2Euros->setValue(0);
        $variant2Euros->setQuestion($this->getReference('question-1'));
        $this->addReference('variant-2-euros', $variant2Euros);
        $manager->persist($variant2Euros);

        $variant10Euros = new Variant();
        $variant10Euros->setText('10 евро');
        $variant10Euros->setValue(0);
        $variant10Euros->setQuestion($this->getReference('question-1'));
        $this->addReference('variant-10-euros', $variant10Euros);
        $manager->persist($variant10Euros);

        $variantSecurityThread = new Variant();
        $variantSecurityThread->setText('защитная нить');
        $variantSecurityThread->setValue(0);
        $variantSecurityThread->setQuestion($this->getReference('question-2'));
        $this->addReference('variant-security-thread', $variantSecurityThread);
        $manager->persist($variantSecurityThread);

        $variantSoundAndStiffnessOfPaper = new Variant();
        $variantSoundAndStiffnessOfPaper->setText('звонкость и жесткость бумаги');
        $variantSoundAndStiffnessOfPaper->setValue(1);
        $variantSoundAndStiffnessOfPaper->setQuestion($this->getReference('question-2'));
        $this->addReference('variant-sound-and-stiffness-of-paper', $variantSoundAndStiffnessOfPaper);
        $manager->persist($variantSoundAndStiffnessOfPaper);

        $variantWaterImage = new Variant();
        $variantWaterImage->setText('водяное изображение (слева лицевой стороны) на белом поле');
        $variantWaterImage->setValue(1);
        $variantWaterImage->setQuestion($this->getReference('question-2'));
        $this->addReference('variant-water-image', $variantWaterImage);
        $manager->persist($variantWaterImage);

        $variantHologram = new Variant();
        $variantHologram->setText('голограмма');
        $variantHologram->setValue(0);
        $variantHologram->setQuestion($this->getReference('question-2'));
        $this->addReference('variant-hologram', $variantHologram);
        $manager->persist($variantHologram);

        $variantLuminescentFibers = new Variant();
        $variantLuminescentFibers->setText('люминисцирующие волокна');
        $variantLuminescentFibers->setValue(0);
        $variantLuminescentFibers->setQuestion($this->getReference('question-2'));
        $this->addReference('variant-luminescent-fibers', $variantLuminescentFibers);
        $manager->persist($variantLuminescentFibers);

        $variantMagneticControl = new Variant();
        $variantMagneticControl->setText('магнитный контроль');
        $variantMagneticControl->setValue(0);
        $variantMagneticControl->setQuestion($this->getReference('question-2'));
        $this->addReference('variant-magnetic-control', $variantMagneticControl);
        $manager->persist($variantMagneticControl);

        $manager->flush();

        /** @var \App\Entity\Question $question1 */
        $question1 = $this->getReference('question-1');
        $question1->addVariant($this->getReference('variant-1-euro'));
        $question1->addVariant($this->getReference('variant-5-euros'));
        $question1->addVariant($this->getReference('variant-2-euros'));
        $question1->addVariant($this->getReference('variant-10-euros'));
        $manager->persist($question1);

        /** @var \App\Entity\Question $question2 */
        $question2 = $this->getReference('question-2');
        $question2->addVariant($this->getReference('variant-security-thread'));
        $question2->addVariant($this->getReference('variant-sound-and-stiffness-of-paper'));
        $question2->addVariant($this->getReference('variant-water-image'));
        $question2->addVariant($this->getReference('variant-hologram'));
        $question2->addVariant($this->getReference('variant-luminescent-fibers'));
        $question2->addVariant($this->getReference('variant-magnetic-control'));
        $manager->persist($question2);

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
