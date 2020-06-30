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

        $variantPortraits = new Variant();
        $variantPortraits->setText('портреты известных людей');
        $variantPortraits->setValue(0);
        $variantPortraits->setQuestion($this->getReference('question-3'));
        $this->addReference('variant-portraits', $variantPortraits);
        $manager->persist($variantPortraits);

        $variantArchitecturalStructures = new Variant();
        $variantArchitecturalStructures->setText('архитектурные сооружения');
        $variantArchitecturalStructures->setValue(0);
        $variantArchitecturalStructures->setQuestion($this->getReference('question-3'));
        $this->addReference('variant-architectural-structures', $variantArchitecturalStructures);
        $manager->persist($variantArchitecturalStructures);

        $variantAnimals = new Variant();
        $variantAnimals->setText('изображения животных');
        $variantAnimals->setValue(1);
        $variantAnimals->setQuestion($this->getReference('question-3'));
        $this->addReference('variant-animals', $variantAnimals);
        $manager->persist($variantAnimals);

        $variantCoatOfArms = new Variant();
        $variantCoatOfArms->setText('изображение герба');
        $variantCoatOfArms->setValue(0);
        $variantCoatOfArms->setQuestion($this->getReference('question-3'));
        $this->addReference('variant-coat-of-arms', $variantCoatOfArms);
        $manager->persist($variantCoatOfArms);

        $variant200Euros = new Variant();
        $variant200Euros->setText('200 евро');
        $variant200Euros->setValue(0);
        $variant200Euros->setQuestion($this->getReference('question-4'));
        $this->addReference('variant-200-euros', $variant200Euros);
        $manager->persist($variant200Euros);

        $variant1000Euros = new Variant();
        $variant1000Euros->setText('1000 евро');
        $variant1000Euros->setValue(0);
        $variant1000Euros->setQuestion($this->getReference('question-4'));
        $this->addReference('variant-1000-euros', $variant1000Euros);
        $manager->persist($variant1000Euros);

        $variant500Euros = new Variant();
        $variant500Euros->setText('500 евро');
        $variant500Euros->setValue(1);
        $variant500Euros->setQuestion($this->getReference('question-4'));
        $this->addReference('variant-500-euros', $variant500Euros);
        $manager->persist($variant500Euros);

        $variant10000Euros = new Variant();
        $variant10000Euros->setText('10000 евро');
        $variant10000Euros->setValue(0);
        $variant10000Euros->setQuestion($this->getReference('question-4'));
        $this->addReference('variant-10000-euros', $variant10000Euros);
        $manager->persist($variant10000Euros);

        $variantGrushevskyi = new Variant();
        $variantGrushevskyi->setText('Михаил Грушевский');
        $variantGrushevskyi->setValue(0);
        $variantGrushevskyi->setQuestion($this->getReference('question-5'));
        $this->addReference('variant-grushevskyi', $variantGrushevskyi);
        $manager->persist($variantGrushevskyi);

        $variantSkovoroda = new Variant();
        $variantSkovoroda->setText('Григорий Сковорода');
        $variantSkovoroda->setValue(0);
        $variantSkovoroda->setQuestion($this->getReference('question-5'));
        $this->addReference('variant-skovoroda', $variantSkovoroda);
        $manager->persist($variantSkovoroda);

        $variantVladimirGreat = new Variant();
        $variantVladimirGreat->setText('Владимир Великий');
        $variantVladimirGreat->setValue(0);
        $variantVladimirGreat->setQuestion($this->getReference('question-5'));
        $this->addReference('variant-vladimir-great', $variantVladimirGreat);
        $manager->persist($variantVladimirGreat);

        $variantVladimirVernadskyi = new Variant();
        $variantVladimirVernadskyi->setText('Владимир Вернадский');
        $variantVladimirVernadskyi->setValue(1);
        $variantVladimirVernadskyi->setQuestion($this->getReference('question-5'));
        $this->addReference('variant-vladimir-vernadskyi', $variantVladimirVernadskyi);
        $manager->persist($variantVladimirVernadskyi);

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

        /** @var \App\Entity\Question $question3 */
        $question3 = $this->getReference('question-3');
        $question3->addVariant($this->getReference('variant-portraits'));
        $question3->addVariant($this->getReference('variant-architectural-structures'));
        $question3->addVariant($this->getReference('variant-animals'));
        $question3->addVariant($this->getReference('variant-coat-of-arms'));
        $manager->persist($question3);

        /** @var \App\Entity\Question $question4 */
        $question4 = $this->getReference('question-4');
        $question4->addVariant($this->getReference('variant-200-euros'));
        $question4->addVariant($this->getReference('variant-1000-euros'));
        $question4->addVariant($this->getReference('variant-500-euros'));
        $question4->addVariant($this->getReference('variant-10000-euros'));
        $manager->persist($question4);

        /** @var \App\Entity\Question $question5 */
        $question5 = $this->getReference('question-5');
        $question5->addVariant($this->getReference('variant-grushevskyi'));
        $question5->addVariant($this->getReference('variant-skovoroda'));
        $question5->addVariant($this->getReference('variant-vladimir-great'));
        $question5->addVariant($this->getReference('variant-vladimir-vernadskyi'));
        $manager->persist($question5);

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
