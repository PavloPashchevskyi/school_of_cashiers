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

        $variantLinaKostenko = new Variant();
        $variantLinaKostenko->setText('Лина Костенко');
        $variantLinaKostenko->setValue(0);
        $variantLinaKostenko->setQuestion($this->getReference('question-6'));
        $this->addReference('variant-lina-kostenko', $variantLinaKostenko);
        $manager->persist($variantLinaKostenko);

        $variantTarasShevchenko = new Variant();
        $variantTarasShevchenko->setText('Тарас Шевченко');
        $variantTarasShevchenko->setValue(0);
        $variantTarasShevchenko->setQuestion($this->getReference('question-6'));
        $this->addReference('variant-taras-shevchenko', $variantTarasShevchenko);
        $manager->persist($variantTarasShevchenko);

        $variantLesyaUkrayinka = new Variant();
        $variantLesyaUkrayinka->setText('Леся Украинка');
        $variantLesyaUkrayinka->setValue(1);
        $variantLesyaUkrayinka->setQuestion($this->getReference('question-6'));
        $this->addReference('variant-lesya-ukrayinka', $variantLesyaUkrayinka);
        $manager->persist($variantLesyaUkrayinka);

        $variantIvanFranko = new Variant();
        $variantIvanFranko->setText('Иван Франко');
        $variantIvanFranko->setValue(0);
        $variantIvanFranko->setQuestion($this->getReference('question-6'));
        $this->addReference('variant-ivan-franko', $variantIvanFranko);
        $manager->persist($variantIvanFranko);

        $variantUltravioletInscription = new Variant();
        $variantUltravioletInscription->setText('Специальная надпись которую видно в ультрофиолете');
        $variantUltravioletInscription->setValue(0);
        $variantUltravioletInscription->setQuestion($this->getReference('question-7'));
        $this->addReference('variant-ultraviolet-inscription', $variantUltravioletInscription);
        $manager->persist($variantUltravioletInscription);

        $variantSignsForLowVision = new Variant();
        $variantSignsForLowVision->setText('спец знаки для ослабленного зрения');
        $variantSignsForLowVision->setValue(0);
        $variantSignsForLowVision->setQuestion($this->getReference('question-7'));
        $this->addReference('variant-signs-for-low-vision', $variantSignsForLowVision);
        $manager->persist($variantSignsForLowVision);

        $variantHiddenFaceValueImage = new Variant();
        $variantHiddenFaceValueImage->setText('Скрытое изображение номинала');
        $variantHiddenFaceValueImage->setValue(1);
        $variantHiddenFaceValueImage->setQuestion($this->getReference('question-7'));
        $this->addReference('variant-hidden-face-value-image', $variantHiddenFaceValueImage);
        $manager->persist($variantHiddenFaceValueImage);

        $variantMicroSeal = new Variant();
        $variantMicroSeal->setText('микропечать');
        $variantMicroSeal->setValue(0);
        $variantMicroSeal->setQuestion($this->getReference('question-7'));
        $this->addReference('variant-micro-seal', $variantMicroSeal);
        $manager->persist($variantMicroSeal);

        $variantLatentImage = new Variant();
        $variantLatentImage->setText('Скрытое изображение на рисунке, которое видно при определенном угле наклона');
        $variantLatentImage->setValue(0);
        $variantLatentImage->setQuestion($this->getReference('question-8'));
        $this->addReference('variant-latent-image', $variantLatentImage);
        $manager->persist($variantLatentImage);

        $variantSignsForLowVision8 = new Variant();
        $variantSignsForLowVision8->setText('спец знаки для ослабленного зрения');
        $variantSignsForLowVision8->setValue(0);
        $variantSignsForLowVision8->setQuestion($this->getReference('question-8'));
        $this->addReference('variant-signs-for-low-vision-8', $variantSignsForLowVision8);
        $manager->persist($variantSignsForLowVision8);

        $variantUltravioletInscription8 = new Variant();
        $variantUltravioletInscription8->setText('Специальная надпись которую видно в ультрофиолете');
        $variantUltravioletInscription8->setValue(1);
        $variantUltravioletInscription8->setQuestion($this->getReference('question-8'));
        $this->addReference('variant-ultraviolet-inscription-8', $variantUltravioletInscription8);
        $manager->persist($variantUltravioletInscription8);

        $variantMicroSeal8 = new Variant();
        $variantMicroSeal8->setText('микропечать');
        $variantMicroSeal8->setValue(0);
        $variantMicroSeal8->setQuestion($this->getReference('question-8'));
        $this->addReference('variant-micro-seal-8', $variantMicroSeal8);
        $manager->persist($variantMicroSeal8);

        $variantFrontSideWithUltraviolet = new Variant();
        $variantFrontSideWithUltraviolet->setText('только с лицевой строны при ультрофиолете');
        $variantFrontSideWithUltraviolet->setValue(0);
        $variantFrontSideWithUltraviolet->setQuestion($this->getReference('question-9'));
        $this->addReference('variant-front-side-with-ultraviolet', $variantFrontSideWithUltraviolet);
        $manager->persist($variantFrontSideWithUltraviolet);

        $variantBothSidesWithUltraviolet = new Variant();
        $variantBothSidesWithUltraviolet->setText('нить видно с двух сторон при ультрофиолете');
        $variantBothSidesWithUltraviolet->setValue(0);
        $variantBothSidesWithUltraviolet->setQuestion($this->getReference('question-9'));
        $this->addReference('variant-both-sides-with-ultraviolet', $variantBothSidesWithUltraviolet);
        $manager->persist($variantBothSidesWithUltraviolet);

        $variantBackSideWithInfrared = new Variant();
        $variantBackSideWithInfrared->setText('только с обратной стороны при инфракрасном контроле');
        $variantBackSideWithInfrared->setValue(1);
        $variantBackSideWithInfrared->setQuestion($this->getReference('question-9'));
        $this->addReference('variant-back-side-with-infrared', $variantBackSideWithInfrared);
        $manager->persist($variantBackSideWithInfrared);

        $variantBothSidesWithInfrared = new Variant();
        $variantBothSidesWithInfrared->setText('нить видно с двух сторон при инфракрасном контроле');
        $variantBothSidesWithInfrared->setValue(0);
        $variantBothSidesWithInfrared->setQuestion($this->getReference('question-9'));
        $this->addReference('variant-both-sides-with-infrared', $variantBothSidesWithInfrared);
        $manager->persist($variantBothSidesWithInfrared);

        $variantRR = new Variant();
        $variantRR->setText('РР');
        $variantRR->setValue(0);
        $variantRR->setQuestion($this->getReference('question-10'));
        $this->addReference('variant-rr', $variantRR);
        $manager->persist($variantRR);

        $variantNominal = new Variant();
        $variantNominal->setText('номинал');
        $variantNominal->setValue(0);
        $variantNominal->setQuestion($this->getReference('question-10'));
        $this->addReference('variant-nominal', $variantNominal);
        $manager->persist($variantNominal);

        $variantRF = new Variant();
        $variantRF->setText('РФ');
        $variantRF->setValue(1);
        $variantRF->setQuestion($this->getReference('question-10'));
        $this->addReference('variant-rf', $variantRF);
        $manager->persist($variantRF);

        $variantTsrb = new Variant();
        $variantTsrb->setText('ЦРБ');
        $variantTsrb->setValue(0);
        $variantTsrb->setQuestion($this->getReference('question-10'));
        $this->addReference('variant-tsrb', $variantTsrb);
        $manager->persist($variantTsrb);

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

        /** @var \App\Entity\Question $question6 */
        $question6 = $this->getReference('question-6');
        $question6->addVariant($this->getReference('variant-lina-kostenko'));
        $question6->addVariant($this->getReference('variant-taras-shevchenko'));
        $question6->addVariant($this->getReference('variant-lesya-ukrayinka'));
        $question6->addVariant($this->getReference('variant-ivan-franko'));
        $manager->persist($question6);

        /** @var \App\Entity\Question $question7 */
        $question7 = $this->getReference('question-7');
        $question7->addVariant($this->getReference('variant-ultraviolet-inscription'));
        $question7->addVariant($this->getReference('variant-signs-for-low-vision'));
        $question7->addVariant($this->getReference('variant-hidden-face-value-image'));
        $question7->addVariant($this->getReference('variant-micro-seal'));
        $manager->persist($question7);

        /** @var \App\Entity\Question $question8 */
        $question8 = $this->getReference('question-8');
        $question8->addVariant($this->getReference('variant-latent-image'));
        $question8->addVariant($this->getReference('variant-signs-for-low-vision-8'));
        $question8->addVariant($this->getReference('variant-ultraviolet-inscription-8'));
        $question8->addVariant($this->getReference('variant-micro-seal-8'));
        $manager->persist($question8);

        /** @var \App\Entity\Question $question9 */
        $question9 = $this->getReference('question-9');
        $question9->addVariant($this->getReference('variant-front-side-with-ultraviolet'));
        $question9->addVariant($this->getReference('variant-both-sides-with-ultraviolet'));
        $question9->addVariant($this->getReference('variant-back-side-with-infrared'));
        $question9->addVariant($this->getReference('variant-both-sides-with-infrared'));
        $manager->persist($question9);

        /** @var \App\Entity\Question $question10 */
        $question10 = $this->getReference('question-10');
        $question10->addVariant($this->getReference('variant-rr'));
        $question10->addVariant($this->getReference('variant-nominal'));
        $question10->addVariant($this->getReference('variant-rf'));
        $question10->addVariant($this->getReference('variant-tsrb'));
        $manager->persist($question10);

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
