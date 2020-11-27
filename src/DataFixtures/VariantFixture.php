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
        $variant1Euro->setText('1 Евро');
        $variant1Euro->setValue(0);
        $variant1Euro->setQuestion($this->getReference('question-1'));
        $this->addReference('variant-1-euro', $variant1Euro);
        $manager->persist($variant1Euro);

        $variant5Euros = new Variant();
        $variant5Euros->setText('5 Евро');
        $variant5Euros->setValue(1);
        $variant5Euros->setQuestion($this->getReference('question-1'));
        $this->addReference('variant-5-euros', $variant5Euros);
        $manager->persist($variant5Euros);

        $variant2Euros = new Variant();
        $variant2Euros->setText('2 Евро');
        $variant2Euros->setValue(0);
        $variant2Euros->setQuestion($this->getReference('question-1'));
        $this->addReference('variant-2-euros', $variant2Euros);
        $manager->persist($variant2Euros);

        $variant10Euros = new Variant();
        $variant10Euros->setText('10 Евро');
        $variant10Euros->setValue(0);
        $variant10Euros->setQuestion($this->getReference('question-1'));
        $this->addReference('variant-10-euros', $variant10Euros);
        $manager->persist($variant10Euros);

        $variantSecurityThread = new Variant();
        $variantSecurityThread->setText('Защитная нить');
        $variantSecurityThread->setValue(0);
        $variantSecurityThread->setQuestion($this->getReference('question-2'));
        $this->addReference('variant-security-thread', $variantSecurityThread);
        $manager->persist($variantSecurityThread);

        $variantSoundAndStiffnessOfPaper = new Variant();
        $variantSoundAndStiffnessOfPaper->setText('Звонкость и жесткость бумаги');
        $variantSoundAndStiffnessOfPaper->setValue(1);
        $variantSoundAndStiffnessOfPaper->setQuestion($this->getReference('question-2'));
        $this->addReference('variant-sound-and-stiffness-of-paper', $variantSoundAndStiffnessOfPaper);
        $manager->persist($variantSoundAndStiffnessOfPaper);

        $variantWaterImage = new Variant();
        $variantWaterImage->setText('Водяное изображение (слева лицевой стороны) на белом поле');
        $variantWaterImage->setValue(1);
        $variantWaterImage->setQuestion($this->getReference('question-2'));
        $this->addReference('variant-water-image', $variantWaterImage);
        $manager->persist($variantWaterImage);

        $variantHologram = new Variant();
        $variantHologram->setText('Голограмма');
        $variantHologram->setValue(0);
        $variantHologram->setQuestion($this->getReference('question-2'));
        $this->addReference('variant-hologram', $variantHologram);
        $manager->persist($variantHologram);

        $variantLuminescentFibers = new Variant();
        $variantLuminescentFibers->setText('Люминисцирующие волокна');
        $variantLuminescentFibers->setValue(0);
        $variantLuminescentFibers->setQuestion($this->getReference('question-2'));
        $this->addReference('variant-luminescent-fibers', $variantLuminescentFibers);
        $manager->persist($variantLuminescentFibers);

        $variantMagneticControl = new Variant();
        $variantMagneticControl->setText('Магнитный контроль');
        $variantMagneticControl->setValue(0);
        $variantMagneticControl->setQuestion($this->getReference('question-2'));
        $this->addReference('variant-magnetic-control', $variantMagneticControl);
        $manager->persist($variantMagneticControl);

        $variantPortraits = new Variant();
        $variantPortraits->setText('Портреты известных людей');
        $variantPortraits->setValue(0);
        $variantPortraits->setQuestion($this->getReference('question-3'));
        $this->addReference('variant-portraits', $variantPortraits);
        $manager->persist($variantPortraits);

        $variantArchitecturalStructures = new Variant();
        $variantArchitecturalStructures->setText('Архитектурные сооружения');
        $variantArchitecturalStructures->setValue(0);
        $variantArchitecturalStructures->setQuestion($this->getReference('question-3'));
        $this->addReference('variant-architectural-structures', $variantArchitecturalStructures);
        $manager->persist($variantArchitecturalStructures);

        $variantAnimals = new Variant();
        $variantAnimals->setText('Изображения животных');
        $variantAnimals->setValue(1);
        $variantAnimals->setQuestion($this->getReference('question-3'));
        $this->addReference('variant-animals', $variantAnimals);
        $manager->persist($variantAnimals);

        $variantCoatOfArms = new Variant();
        $variantCoatOfArms->setText('Изображение герба');
        $variantCoatOfArms->setValue(0);
        $variantCoatOfArms->setQuestion($this->getReference('question-3'));
        $this->addReference('variant-coat-of-arms', $variantCoatOfArms);
        $manager->persist($variantCoatOfArms);

        $variant200Euros = new Variant();
        $variant200Euros->setText('200 Евро');
        $variant200Euros->setValue(0);
        $variant200Euros->setQuestion($this->getReference('question-4'));
        $this->addReference('variant-200-euros', $variant200Euros);
        $manager->persist($variant200Euros);

        $variant1000Euros = new Variant();
        $variant1000Euros->setText('1000 Евро');
        $variant1000Euros->setValue(0);
        $variant1000Euros->setQuestion($this->getReference('question-4'));
        $this->addReference('variant-1000-euros', $variant1000Euros);
        $manager->persist($variant1000Euros);

        $variant500Euros = new Variant();
        $variant500Euros->setText('500 Евро');
        $variant500Euros->setValue(1);
        $variant500Euros->setQuestion($this->getReference('question-4'));
        $this->addReference('variant-500-euros', $variant500Euros);
        $manager->persist($variant500Euros);

        $variant10000Euros = new Variant();
        $variant10000Euros->setText('10000 Евро');
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
        $variantUltravioletInscription->setText('Специальная надпись, которую видно в ультрофиолете');
        $variantUltravioletInscription->setValue(0);
        $variantUltravioletInscription->setQuestion($this->getReference('question-7'));
        $this->addReference('variant-ultraviolet-inscription', $variantUltravioletInscription);
        $manager->persist($variantUltravioletInscription);

        $variantSignsForLowVision = new Variant();
        $variantSignsForLowVision->setText('Спец знаки для ослабленного зрения');
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
        $variantMicroSeal->setText('Микропечать');
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
        $variantSignsForLowVision8->setText('Спец знаки для ослабленного зрения');
        $variantSignsForLowVision8->setValue(0);
        $variantSignsForLowVision8->setQuestion($this->getReference('question-8'));
        $this->addReference('variant-signs-for-low-vision-8', $variantSignsForLowVision8);
        $manager->persist($variantSignsForLowVision8);

        $variantUltravioletInscription8 = new Variant();
        $variantUltravioletInscription8->setText('Специальная надпись, которую видно в ультрофиолете');
        $variantUltravioletInscription8->setValue(1);
        $variantUltravioletInscription8->setQuestion($this->getReference('question-8'));
        $this->addReference('variant-ultraviolet-inscription-8', $variantUltravioletInscription8);
        $manager->persist($variantUltravioletInscription8);

        $variantMicroSeal8 = new Variant();
        $variantMicroSeal8->setText('Микропечать');
        $variantMicroSeal8->setValue(0);
        $variantMicroSeal8->setQuestion($this->getReference('question-8'));
        $this->addReference('variant-micro-seal-8', $variantMicroSeal8);
        $manager->persist($variantMicroSeal8);

        $variantFrontSideWithUltraviolet = new Variant();
        $variantFrontSideWithUltraviolet->setText('Только с лицевой строны при ультрофиолете');
        $variantFrontSideWithUltraviolet->setValue(0);
        $variantFrontSideWithUltraviolet->setQuestion($this->getReference('question-9'));
        $this->addReference('variant-front-side-with-ultraviolet', $variantFrontSideWithUltraviolet);
        $manager->persist($variantFrontSideWithUltraviolet);

        $variantBothSidesWithUltraviolet = new Variant();
        $variantBothSidesWithUltraviolet->setText('Нить видно с двух сторон при ультрофиолете');
        $variantBothSidesWithUltraviolet->setValue(0);
        $variantBothSidesWithUltraviolet->setQuestion($this->getReference('question-9'));
        $this->addReference('variant-both-sides-with-ultraviolet', $variantBothSidesWithUltraviolet);
        $manager->persist($variantBothSidesWithUltraviolet);

        $variantBackSideWithInfrared = new Variant();
        $variantBackSideWithInfrared->setText('Только с обратной стороны при инфракрасном контроле');
        $variantBackSideWithInfrared->setValue(1);
        $variantBackSideWithInfrared->setQuestion($this->getReference('question-9'));
        $this->addReference('variant-back-side-with-infrared', $variantBackSideWithInfrared);
        $manager->persist($variantBackSideWithInfrared);

        $variantBothSidesWithInfrared = new Variant();
        $variantBothSidesWithInfrared->setText('Нить видно с двух сторон при инфракрасном контроле');
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
        $variantNominal->setText('Номинал');
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

        $variant500Rub = new Variant();
        $variant500Rub->setText('500 Рублей');
        $variant500Rub->setValue(0);
        $variant500Rub->setQuestion($this->getReference('question-11'));
        $this->addReference('variant-500-rub', $variant500Rub);
        $manager->persist($variant500Rub);

        $variant2000Rub = new Variant();
        $variant2000Rub->setText('2000 Рублей');
        $variant2000Rub->setValue(0);
        $variant2000Rub->setQuestion($this->getReference('question-11'));
        $this->addReference('variant-2000-rub', $variant2000Rub);
        $manager->persist($variant2000Rub);

        $variant1000Rub = new Variant();
        $variant1000Rub->setText('1000 Рублей');
        $variant1000Rub->setValue(0);
        $variant1000Rub->setQuestion($this->getReference('question-11'));
        $this->addReference('variant-1000-rub', $variant1000Rub);
        $manager->persist($variant1000Rub);

        $variant5000Rub = new Variant();
        $variant5000Rub->setText('5000 Рублей');
        $variant5000Rub->setValue(1);
        $variant5000Rub->setQuestion($this->getReference('question-11'));
        $this->addReference('variant-5000-rub', $variant5000Rub);
        $manager->persist($variant5000Rub);

        $variantUah = new Variant();
        $variantUah->setText('Гривны');
        $variantUah->setValue(0);
        $variantUah->setQuestion($this->getReference('question-12'));
        $this->addReference('variant-uah', $variantUah);
        $manager->persist($variantUah);

        $variantRub = new Variant();
        $variantRub->setText('Рубли');
        $variantRub->setValue(0);
        $variantRub->setQuestion($this->getReference('question-12'));
        $this->addReference('variant-rub', $variantRub);
        $manager->persist($variantRub);

        $variantEur = new Variant();
        $variantEur->setText('Евро');
        $variantEur->setValue(1);
        $variantEur->setQuestion($this->getReference('question-12'));
        $this->addReference('variant-eur', $variantEur);
        $manager->persist($variantEur);

        $variantUsd = new Variant();
        $variantUsd->setText('Доллары');
        $variantUsd->setValue(0);
        $variantUsd->setQuestion($this->getReference('question-12'));
        $this->addReference('variant-usd', $variantUsd);
        $manager->persist($variantUsd);

        $variantVarnish = new Variant();
        $variantVarnish->setText('Эмблема нанесена цветопеременным лаком');
        $variantVarnish->setValue(1);
        $variantVarnish->setQuestion($this->getReference('question-13'));
        $this->addReference('variant-varnish', $variantVarnish);
        $manager->persist($variantVarnish);

        $variantInTheLight = new Variant();
        $variantInTheLight->setText('Эмблема видна только на просвет');
        $variantInTheLight->setValue(0);
        $variantInTheLight->setQuestion($this->getReference('question-13'));
        $this->addReference('variant-in-the-light', $variantInTheLight);
        $manager->persist($variantInTheLight);

        $variantWithUltraviolet = new Variant();
        $variantWithUltraviolet->setText('Эмблему видно только при ультрафиолете');
        $variantWithUltraviolet->setValue(0);
        $variantWithUltraviolet->setQuestion($this->getReference('question-13'));
        $this->addReference('variant-with-ultraviolet', $variantWithUltraviolet);
        $manager->persist($variantWithUltraviolet);

        $variantWithInfrared = new Variant();
        $variantWithInfrared->setText('Эмблему видно только при инфракрасном просвете');
        $variantWithInfrared->setValue(0);
        $variantWithInfrared->setQuestion($this->getReference('question-13'));
        $this->addReference('variant-with-infrared', $variantWithInfrared);
        $manager->persist($variantWithInfrared);

        $variantRightBottomFront = new Variant();
        $variantRightBottomFront->setText('Справа в нижнем углу лицевой стороны');
        $variantRightBottomFront->setValue(0);
        $variantRightBottomFront->setQuestion($this->getReference('question-14'));
        $this->addReference('variant-right-bottom-front', $variantRightBottomFront);
        $manager->persist($variantRightBottomFront);

        $variantRightBottomBack = new Variant();
        $variantRightBottomBack->setText('Справа в нижнем углу обратной стороны');
        $variantRightBottomBack->setValue(0);
        $variantRightBottomBack->setQuestion($this->getReference('question-14'));
        $this->addReference('variant-right-bottom-back', $variantRightBottomBack);
        $manager->persist($variantRightBottomBack);

        $variantLeftBottomFront = new Variant();
        $variantLeftBottomFront->setText('Слева в нижнем углу лицевой стороны');
        $variantLeftBottomFront->setValue(1);
        $variantLeftBottomFront->setQuestion($this->getReference('question-14'));
        $this->addReference('variant-left-bottom-front', $variantLeftBottomFront);
        $manager->persist($variantLeftBottomFront);

        $variantLeftBottomBack = new Variant();
        $variantLeftBottomBack->setText('Слева в нижнем углу обратной стороны');
        $variantLeftBottomBack->setValue(0);
        $variantLeftBottomBack->setQuestion($this->getReference('question-14'));
        $this->addReference('variant-left-bottom-back', $variantLeftBottomBack);
        $manager->persist($variantLeftBottomBack);

        $variantNominalInDigits = new Variant();
        $variantNominalInDigits->setText('Номинал купюры цифрами');
        $variantNominalInDigits->setValue(0);
        $variantNominalInDigits->setQuestion($this->getReference('question-15'));
        $this->addReference('variant-nominal-in-digits', $variantNominalInDigits);
        $manager->persist($variantNominalInDigits);

        $variantPortraitCollar = new Variant();
        $variantPortraitCollar->setText('Воротник портрета');
        $variantPortraitCollar->setValue(1);
        $variantPortraitCollar->setQuestion($this->getReference('question-15'));
        $this->addReference('variant-portrait-collar', $variantPortraitCollar);
        $manager->persist($variantPortraitCollar);

        $variantUsaSubscription = new Variant();
        $variantUsaSubscription->setText('Надпись the united states of Amerika');
        $variantUsaSubscription->setValue(1);
        $variantUsaSubscription->setQuestion($this->getReference('question-15'));
        $this->addReference('variant-usa-subscription', $variantUsaSubscription);
        $manager->persist($variantUsaSubscription);

        $variantNominalInLetters = new Variant();
        $variantNominalInLetters->setText('Номинал купюры буквами');
        $variantNominalInLetters->setValue(1);
        $variantNominalInLetters->setQuestion($this->getReference('question-15'));
        $this->addReference('variant-nominal-in-letters', $variantNominalInLetters);
        $manager->persist($variantNominalInLetters);

        $variantUsd = new Variant();
        $variantUsd->setText('Доллар');
        $variantUsd->setValue(1);
        $variantUsd->setQuestion($this->getReference('question-16'));
        $this->addReference('variant-usd-16', $variantUsd);
        $manager->persist($variantUsd);

        $variantGbp = new Variant();
        $variantGbp->setText('Фунты');
        $variantGbp->setValue(0);
        $variantGbp->setQuestion($this->getReference('question-16'));
        $this->addReference('variant-gbp', $variantGbp);
        $manager->persist($variantGbp);

        $variantEur = new Variant();
        $variantEur->setText('Евро');
        $variantEur->setValue(0);
        $variantEur->setQuestion($this->getReference('question-16'));
        $this->addReference('variant-eur-16', $variantEur);
        $manager->persist($variantEur);

        $variantUah = new Variant();
        $variantUah->setText('Гривны');
        $variantUah->setValue(0);
        $variantUah->setQuestion($this->getReference('question-16'));
        $this->addReference('variant-uah-16', $variantUah);
        $manager->persist($variantUah);

        $variant121050100 = new Variant();
        $variant121050100->setText('1, 2, 10, 50, 100');
        $variant121050100->setValue(0);
        $variant121050100->setQuestion($this->getReference('question-17'));
        $this->addReference('variant-121050100', $variant121050100);
        $manager->persist($variant121050100);

        $variant151050100 = new Variant();
        $variant151050100->setText('1, 5, 10, 50, 100');
        $variant151050100->setValue(0);
        $variant151050100->setQuestion($this->getReference('question-17'));
        $this->addReference('variant-151050100', $variant151050100);
        $manager->persist($variant151050100);

        $variant151020501001000 = new Variant();
        $variant151020501001000->setText('1, 5, 10, 20, 50, 100, 1000');
        $variant151020501001000->setValue(0);
        $variant151020501001000->setQuestion($this->getReference('question-17'));
        $this->addReference('variant-151020501001000', $variant151020501001000);
        $manager->persist($variant151020501001000);

        $variant125102050100 = new Variant();
        $variant125102050100->setText('1, 2, 5, 10, 20, 50, 100');
        $variant125102050100->setValue(1);
        $variant125102050100->setQuestion($this->getReference('question-17'));
        $this->addReference('variant-125102050100', $variant125102050100);
        $manager->persist($variant125102050100);

        $variant102050100200 = new Variant();
        $variant102050100200->setText('10, 20, 50, 100, 200');
        $variant102050100200->setValue(1);
        $variant102050100200->setQuestion($this->getReference('question-18'));
        $this->addReference('variant-102050100200', $variant102050100200);
        $manager->persist($variant102050100200);

        $variant102050100200500 = new Variant();
        $variant102050100200500->setText('10, 20, 50, 100, 200, 500');
        $variant102050100200500->setValue(0);
        $variant102050100200500->setQuestion($this->getReference('question-18'));
        $this->addReference('variant-102050100200500', $variant102050100200500);
        $manager->persist($variant102050100200500);

        $variant5102050100200 = new Variant();
        $variant5102050100200->setText('5, 10, 20, 50, 100, 200');
        $variant5102050100200->setValue(0);
        $variant5102050100200->setQuestion($this->getReference('question-18'));
        $this->addReference('variant-5102050100200', $variant5102050100200);
        $manager->persist($variant5102050100200);

        $variant51020501002005001000 = new Variant();
        $variant51020501002005001000->setText('5, 10, 20, 50, 100, 200, 500, 1000');
        $variant51020501002005001000->setValue(0);
        $variant51020501002005001000->setQuestion($this->getReference('question-18'));
        $this->addReference('variant-51020501002005001000', $variant51020501002005001000);
        $manager->persist($variant51020501002005001000);

        $variantGbp = new Variant();
        $variantGbp->setText('Фунты');
        $variantGbp->setValue(0);
        $variantGbp->setQuestion($this->getReference('question-19'));
        $this->addReference('variant-gbp-19', $variantGbp);
        $manager->persist($variantGbp);

        $variantEur = new Variant();
        $variantEur->setText('Евро');
        $variantEur->setValue(0);
        $variantEur->setQuestion($this->getReference('question-19'));
        $this->addReference('variant-eur-19', $variantEur);
        $manager->persist($variantEur);

        $variantUsd = new Variant();
        $variantUsd->setText('Доллары');
        $variantUsd->setValue(0);
        $variantUsd->setQuestion($this->getReference('question-19'));
        $this->addReference('variant-usd-19', $variantUsd);
        $manager->persist($variantUsd);

        $variantPln = new Variant();
        $variantPln->setText('Злотые');
        $variantPln->setValue(1);
        $variantPln->setQuestion($this->getReference('question-19'));
        $this->addReference('variant-pln', $variantPln);
        $manager->persist($variantPln);

        $variantWillNotTake = new Variant();
        $variantWillNotTake->setText('Не буду принимать');
        $variantWillNotTake->setValue(0);
        $variantWillNotTake->setQuestion($this->getReference('question-20'));
        $this->addReference('variant-will-not-take', $variantWillNotTake);
        $manager->persist($variantWillNotTake);

        $variantWillEvaluate = new Variant();
        $variantWillEvaluate->setText('Оценю по шкале ветхости');
        $variantWillEvaluate->setValue(1);
        $variantWillEvaluate->setQuestion($this->getReference('question-20'));
        $this->addReference('variant-will-evaluate', $variantWillEvaluate);
        $manager->persist($variantWillEvaluate);

        $variantWillTakeAsUsual = new Variant();
        $variantWillTakeAsUsual->setText('Прийму как обычную купюру');
        $variantWillTakeAsUsual->setValue(0);
        $variantWillTakeAsUsual->setQuestion($this->getReference('question-20'));
        $this->addReference('variant-will-take-as-usual', $variantWillTakeAsUsual);
        $manager->persist($variantWillTakeAsUsual);

        $variantWillTakeAndDeduct = new Variant();
        $variantWillTakeAndDeduct->setText('Ветхие купюры прийму и вычту 20% стоимости');
        $variantWillTakeAndDeduct->setValue(0);
        $variantWillTakeAndDeduct->setQuestion($this->getReference('question-20'));
        $this->addReference('variant-will-take-and-deduct', $variantWillTakeAndDeduct);
        $manager->persist($variantWillTakeAndDeduct);

        $variant211 = new Variant();
        $variant211->setText('Открыть отделение, ввести код доступа охранной сигнализации, включить свет');
        $variant211->setValue(0);
        $variant211->setQuestion($this->getReference('question-21'));
        $this->addReference('variant-21-1', $variant211);
        $manager->persist($variant211);

        $variant212 = new Variant();
        $variant212->setText('Открыть отделение, сообщить видеооператору о начале работы');
        $variant212->setValue(0);
        $variant212->setQuestion($this->getReference('question-21'));
        $this->addReference('variant-21-2', $variant212);
        $manager->persist($variant212);

        $variant213 = new Variant();
        $variant213->setText('Осмотреть объект визуально, открыть отделение, включить свет, ввести код доступа охранной сигнализации');
        $variant213->setValue(1);
        $variant213->setQuestion($this->getReference('question-21'));
        $this->addReference('variant-21-3', $variant213);
        $manager->persist($variant213);

        $variant214 = new Variant();
        $variant214->setText('Открыть отделение, снять сигнализацию, сообщить видеооператору о начале работы');
        $variant214->setValue(0);
        $variant214->setQuestion($this->getReference('question-21'));
        $this->addReference('variant-21-4', $variant214);
        $manager->persist($variant214);

        $variant221 = new Variant();
        $variant221->setText('Предупредить видеооператора про закрытие отделения, ввести код доступа на сигнализацию, выключить электро приборы, свет, закрыть отделение');
        $variant221->setValue(0);
        $variant221->setQuestion($this->getReference('question-22'));
        $this->addReference('variant-22-1', $variant221);
        $manager->persist($variant221);

        $variant222 = new Variant();
        $variant222->setText('Закрыть сейф, закрыть окна, ввести код доступа охранной сигнализации, выключить электроприборы, выключить свет, закрыть дверь');
        $variant222->setValue(1);
        $variant222->setQuestion($this->getReference('question-22'));
        $this->addReference('variant-22-2', $variant222);
        $manager->persist($variant222);

        $variant223 = new Variant();
        $variant223->setText('Закрыть окна, ввести код доступа охранной сигнализации, выключить электроприборы, выключить свет, закрыть дверь');
        $variant223->setValue(0);
        $variant223->setQuestion($this->getReference('question-22'));
        $this->addReference('variant-22-3', $variant223);
        $manager->persist($variant223);

        $variant224 = new Variant();
        $variant224->setText('Закрыть сейф, закрыть окна, выключить электроприборы, выключить свет, закрыть дверь');
        $variant224->setValue(0);
        $variant224->setQuestion($this->getReference('question-22'));
        $this->addReference('variant-22-4', $variant224);
        $manager->persist($variant224);

        $variant231 = new Variant();
        $variant231->setText('Проверка внутренней службой безопасности');
        $variant231->setValue(1);
        $variant231->setQuestion($this->getReference('question-23'));
        $this->addReference('variant-23-1', $variant231);
        $manager->persist($variant231);

        $variant232 = new Variant();
        $variant232->setText('Проверка Фискальной службой (налоговая)');
        $variant232->setValue(1);
        $variant232->setQuestion($this->getReference('question-23'));
        $this->addReference('variant-23-2', $variant232);
        $manager->persist($variant232);

        $variant233 = new Variant();
        $variant233->setText('Проверка НБУ');
        $variant233->setValue(1);
        $variant233->setQuestion($this->getReference('question-23'));
        $this->addReference('variant-23-3', $variant233);
        $manager->persist($variant233);

        $variant234 = new Variant();
        $variant234->setText('Обыск (проведение следственных действий)');
        $variant234->setValue(1);
        $variant234->setQuestion($this->getReference('question-23'));
        $this->addReference('variant-23-4', $variant234);
        $manager->persist($variant234);

        $variant241 = new Variant();
        $variant241->setText('Сверить предьявленные документы, удостоверяющие личность, с фамилиями в приказе на общий доступ в отделение');
        $variant241->setValue(3);
        $variant241->setQuestion($this->getReference('question-24'));
        $this->addReference('variant-24-1', $variant241);
        $manager->persist($variant241);

        $variant242 = new Variant();
        $variant242->setText('Сообщить о проверке видеооператору');
        $variant242->setValue(1);
        $variant242->setQuestion($this->getReference('question-24'));
        $this->addReference('variant-24-2', $variant242);
        $manager->persist($variant242);

        $variant243 = new Variant();
        $variant243->setText('Сообщить о проверке главному кассиру');
        $variant243->setValue(0);
        $variant243->setQuestion($this->getReference('question-24'));
        $this->addReference('variant-24-3', $variant243);
        $manager->persist($variant243);

        $variant244 = new Variant();
        $variant244->setText('Открыть отделение и предоставить всю необходимую информацию, документацию, произвести пересчет денег в присутствии проверяющего и т.д.');
        $variant244->setValue(4);
        $variant244->setQuestion($this->getReference('question-24'));
        $this->addReference('variant-24-4', $variant244);
        $manager->persist($variant244);

        $variant245 = new Variant();
        $variant245->setText('Перед тем, как открыть отделение, удостовериться, что сейф закрыт');
        $variant245->setValue(0);
        $variant245->setQuestion($this->getReference('question-24'));
        $this->addReference('variant-24-5', $variant245);
        $manager->persist($variant245);

        $variant246 = new Variant();
        $variant246->setText('Попросить видеооператора идентифицировать всех проверяющих');
        $variant246->setValue(2);
        $variant246->setQuestion($this->getReference('question-24'));
        $this->addReference('variant-24-6', $variant246);
        $manager->persist($variant246);

        $variant247 = new Variant();
        $variant247->setText('Закрыть все программы на рабочем столе.');
        $variant247->setValue(0);
        $variant247->setQuestion($this->getReference('question-24'));
        $this->addReference('variant-24-7', $variant247);
        $manager->persist($variant247);

        $variant248 = new Variant();
        $variant248->setText('Не открывать отделение поскольку не было предупреждения о предстоящей проверке');
        $variant248->setValue(0);
        $variant248->setQuestion($this->getReference('question-24'));
        $this->addReference('variant-24-8', $variant248);
        $manager->persist($variant248);

        $variant249 = new Variant();
        $variant249->setText('Пересчитать кассу, закрыть сейф и только потом открыть отделение');
        $variant249->setValue(0);
        $variant249->setQuestion($this->getReference('question-24'));
        $this->addReference('variant-24-9', $variant249);
        $manager->persist($variant249);

        $variant251 = new Variant();
        $variant251->setText('Незамедлительно открыть отделение и предоставить требуемую документацию и информацию');
        $variant251->setValue(0);
        $variant251->setQuestion($this->getReference('question-25'));
        $this->addReference('variant-25-1', $variant251);
        $manager->persist($variant251);

        $variant252 = new Variant();
        $variant252->setText('Сообщить о проверке главному кассиру и сотруднику видеонаблюдения');
        $variant252->setValue(3);
        $variant252->setQuestion($this->getReference('question-25'));
        $this->addReference('variant-25-2', $variant252);
        $manager->persist($variant252);

        $variant253 = new Variant();
        $variant253->setText('Закрыть все окна на своем пк и включить кнопку SOS');
        $variant253->setValue(2);
        $variant253->setQuestion($this->getReference('question-25'));
        $this->addReference('variant-25-3', $variant253);
        $manager->persist($variant253);

        $variant254 = new Variant();
        $variant254->setText('Закрыть сейф');
        $variant254->setValue(0);
        $variant254->setQuestion($this->getReference('question-25'));
        $this->addReference('variant-25-4', $variant254);
        $manager->persist($variant254);

        $variant255 = new Variant();
        $variant255->setText('Взять документы проверяющих через окошко и внимательно изучить');
        $variant255->setValue(1);
        $variant255->setQuestion($this->getReference('question-25'));
        $this->addReference('variant-25-5', $variant255);
        $manager->persist($variant255);

        $variant256 = new Variant();
        $variant256->setText('Попросить документы, удостоверяющие личность, поручение на проверку и переписать на лист бумаги необходимую информацию');
        $variant256->setValue(4);
        $variant256->setQuestion($this->getReference('question-25'));
        $this->addReference('variant-25-6', $variant256);
        $manager->persist($variant256);

        $variant257 = new Variant();
        $variant257->setText('По требованию проверяющих открыть сейф и предоставить возможность пересчитать деньги');
        $variant257->setValue(0);
        $variant257->setQuestion($this->getReference('question-25'));
        $this->addReference('variant-25-7', $variant257);
        $manager->persist($variant257);

        $variant258 = new Variant();
        $variant258->setText('По просьбе проверяющих покинуть отделение и вызвать на торговую точку вышестоящее руководство');
        $variant258->setValue(0);
        $variant258->setQuestion($this->getReference('question-25'));
        $this->addReference('variant-25-8', $variant258);
        $manager->persist($variant258);

        $variant259 = new Variant();
        $variant259->setText('Ознакомиться с актом проверки и сделать копию');
        $variant259->setValue(0);
        $variant259->setQuestion($this->getReference('question-25'));
        $this->addReference('variant-25-9', $variant259);
        $manager->persist($variant259);

        $variant2510 = new Variant();
        $variant2510->setText('Ознакомиться с актом проверки, согласовав с главным кассиром компании, подписать акт и потребовать свой экземпляр');
        $variant2510->setValue(5);
        $variant2510->setQuestion($this->getReference('question-25'));
        $this->addReference('variant-25-10', $variant2510);
        $manager->persist($variant2510);

        $variant261 = new Variant();
        $variant261->setText('ФИО и должность проверяющего');
        $variant261->setValue(1);
        $variant261->setQuestion($this->getReference('question-26'));
        $this->addReference('variant-26-1', $variant261);
        $manager->persist($variant261);

        $variant262 = new Variant();
        $variant262->setText('Наименование и адрес ТТ, на которое выписано направление');
        $variant262->setValue(1);
        $variant262->setQuestion($this->getReference('question-26'));
        $this->addReference('variant-26-2', $variant262);
        $manager->persist($variant262);

        $variant263 = new Variant();
        $variant263->setText('Дата составления направления');
        $variant263->setValue(1);
        $variant263->setQuestion($this->getReference('question-26'));
        $this->addReference('variant-26-3', $variant263);
        $manager->persist($variant263);

        $variant264 = new Variant();
        $variant264->setText('Тематика проверки');
        $variant264->setValue(1);
        $variant264->setQuestion($this->getReference('question-26'));
        $this->addReference('variant-26-4', $variant264);
        $manager->persist($variant264);

        $variant265 = new Variant();
        $variant265->setText('Период проведения проверки');
        $variant265->setValue(1);
        $variant265->setQuestion($this->getReference('question-26'));
        $this->addReference('variant-26-5', $variant265);
        $manager->persist($variant265);

        $variant266 = new Variant();
        $variant266->setText('Перечень всех ТТ сети где будут проведена проверка');
        $variant266->setValue(0);
        $variant266->setQuestion($this->getReference('question-26'));
        $this->addReference('variant-26-6', $variant266);
        $manager->persist($variant266);

        $variant267 = new Variant();
        $variant267->setText('Служебная записка');
        $variant267->setValue(0);
        $variant267->setQuestion($this->getReference('question-26'));
        $this->addReference('variant-26-7', $variant267);
        $manager->persist($variant267);

        $variant268 = new Variant();
        $variant268->setText('Военный билет');
        $variant268->setValue(0);
        $variant268->setQuestion($this->getReference('question-26'));
        $this->addReference('variant-26-8', $variant268);
        $manager->persist($variant268);

        $variant271 = new Variant();
        $variant271->setText('1 проверяющий');
        $variant271->setValue(0);
        $variant271->setQuestion($this->getReference('question-27'));
        $this->addReference('variant-27-1', $variant271);
        $manager->persist($variant271);

        $variant272 = new Variant();
        $variant272->setText('Всегда больше 2-х человек');
        $variant272->setValue(0);
        $variant272->setQuestion($this->getReference('question-27'));
        $this->addReference('variant-27-2', $variant272);
        $manager->persist($variant272);

        $variant273 = new Variant();
        $variant273->setText('Минимум два проверяющих');
        $variant273->setValue(1);
        $variant273->setQuestion($this->getReference('question-27'));
        $this->addReference('variant-27-3', $variant273);
        $manager->persist($variant273);

        $variant274 = new Variant();
        $variant274->setText('Не регламентировано количество');
        $variant274->setValue(0);
        $variant274->setQuestion($this->getReference('question-27'));
        $this->addReference('variant-27-4', $variant274);
        $manager->persist($variant274);

        $variant281 = new Variant();
        $variant281->setText('Копию приказа о проведении проверки');
        $variant281->setValue(1);
        $variant281->setQuestion($this->getReference('question-28'));
        $this->addReference('variant-28-1', $variant281);
        $manager->persist($variant281);

        $variant282 = new Variant();
        $variant282->setText('Служебное удостоверение');
        $variant282->setValue(1);
        $variant282->setQuestion($this->getReference('question-28'));
        $this->addReference('variant-28-2', $variant282);
        $manager->persist($variant282);

        $variant283 = new Variant();
        $variant283->setText('Направление на проверку');
        $variant283->setValue(1);
        $variant283->setQuestion($this->getReference('question-28'));
        $this->addReference('variant-28-3', $variant283);
        $manager->persist($variant283);

        $variant284 = new Variant();
        $variant284->setText('Решение суда');
        $variant284->setValue(0);
        $variant284->setQuestion($this->getReference('question-28'));
        $this->addReference('variant-28-4', $variant284);
        $manager->persist($variant284);

        $variant291 = new Variant();
        $variant291->setText('Дата выдачи');
        $variant291->setValue(1);
        $variant291->setQuestion($this->getReference('question-29'));
        $this->addReference('variant-29-1', $variant291);
        $manager->persist($variant291);

        $variant292 = new Variant();
        $variant292->setText('Подпись и печать контролиующего органа');
        $variant292->setValue(1);
        $variant292->setQuestion($this->getReference('question-29'));
        $this->addReference('variant-29-2', $variant292);
        $manager->persist($variant292);

        $variant293 = new Variant();
        $variant293->setText('Наименование контролирующего органа');
        $variant293->setValue(1);
        $variant293->setQuestion($this->getReference('question-29'));
        $this->addReference('variant-29-3', $variant293);
        $manager->persist($variant293);

        $variant294 = new Variant();
        $variant294->setText('Основания для проведения проверки');
        $variant294->setValue(1);
        $variant294->setQuestion($this->getReference('question-29'));
        $this->addReference('variant-29-4', $variant294);
        $manager->persist($variant294);

        $variant295 = new Variant();
        $variant295->setText('Наименование и реквизиты субъекта, который проверяется');
        $variant295->setValue(1);
        $variant295->setQuestion($this->getReference('question-29'));
        $this->addReference('variant-29-5', $variant295);
        $manager->persist($variant295);

        $variant296 = new Variant();
        $variant296->setText('Дата начала и продолжительность проверки');
        $variant296->setValue(1);
        $variant296->setQuestion($this->getReference('question-29'));
        $this->addReference('variant-29-6', $variant296);
        $manager->persist($variant296);

        $variant297 = new Variant();
        $variant297->setText('Вид (документальная плановая / внеплановая или фактическая проверка)');
        $variant297->setValue(1);
        $variant297->setQuestion($this->getReference('question-29'));
        $this->addReference('variant-29-7', $variant297);
        $manager->persist($variant297);

        $variant298 = new Variant();
        $variant298->setText('Цель проверки');
        $variant298->setValue(1);
        $variant298->setQuestion($this->getReference('question-29'));
        $this->addReference('variant-29-8', $variant298);
        $manager->persist($variant298);

        $variant299 = new Variant();
        $variant299->setText('Сумма штрафа');
        $variant299->setValue(0);
        $variant299->setQuestion($this->getReference('question-29'));
        $this->addReference('variant-29-9', $variant299);
        $manager->persist($variant299);

        $variant2910 = new Variant();
        $variant2910->setText('Решение суда');
        $variant2910->setValue(0);
        $variant2910->setQuestion($this->getReference('question-29'));
        $this->addReference('variant-29-10', $variant2910);
        $manager->persist($variant2910);

        $variant301 = new Variant();
        $variant301->setText('Ознакомиться с распоряжением, сверить ФИО в документе с удостоверением личности,  выключить компьютер, сообщить о проверке руководству, описать всю технику, которую изымают и переписать номера банкнот, которые изымают');
        $variant301->setValue(0);
        $variant301->setQuestion($this->getReference('question-30'));
        $this->addReference('variant-30-1', $variant301);
        $manager->persist($variant301);

        $variant302 = new Variant();
        $variant302->setText('Ознакомиться с решением суда, сверить дату, адрес, ФИО, перечень изымаемого, переписать эту информацию на лист бумаги, предупредить руководство,  выключить компьютер, получить копию решения суда, сверить изымаемую технику с решением суда, переписать номера изымаемых купюр или снять видео, после проверки обязательно получить протокол обыска и описи.');
        $variant302->setValue(1);
        $variant302->setQuestion($this->getReference('question-30'));
        $this->addReference('variant-30-2', $variant302);
        $manager->persist($variant302);

        $variant303 = new Variant();
        $variant303->setText('Закрыть отделение, сообщить о проверке вышестоящему руководству, и ожидать приезда сотрудников сб');
        $variant303->setValue(0);
        $variant303->setQuestion($this->getReference('question-30'));
        $this->addReference('variant-30-3', $variant303);
        $manager->persist($variant303);

        $variant304 = new Variant();
        $variant304->setText('Ознакомиться с решением суда, сверить дату, адрес, ФИО, перечень изымаемого, переписать эту информацию на лист бумаги, предупредить руководство, выключить компьютер, получить копию решения суда, открыть сейф и присутствовать при пересчете денежных средств, сверить изымаемую технику с решением суда, переписать номера изымаемых купюр или снять видео, дать письменные показания на предмет найденных нарушений и после проверки обязательно получить протокол обыска и описи.');
        $variant304->setValue(0);
        $variant304->setQuestion($this->getReference('question-30'));
        $this->addReference('variant-30-4', $variant304);
        $manager->persist($variant304);

        $variant305 = new Variant();
        $variant305->setText('Закрыть отделение, сообщить о проверке вышестоящему руководству, и ожидать приезда сотрудников сб, после чего покинуть торговую точку.');
        $variant305->setValue(0);
        $variant305->setQuestion($this->getReference('question-30'));
        $this->addReference('variant-30-5', $variant305);
        $manager->persist($variant305);

        $variant311 = new Variant();
        $variant311->setText('Свыше 500 грн');
        $variant311->setValue(0);
        $variant311->setQuestion($this->getReference('question-31'));
        $this->addReference('variant-31-1', $variant311);
        $manager->persist($variant311);

        $variant312 = new Variant();
        $variant312->setText('О личных средствах не нужно никому сообщать');
        $variant312->setValue(0);
        $variant312->setQuestion($this->getReference('question-31'));
        $this->addReference('variant-31-2', $variant312);
        $manager->persist($variant312);

        $variant313 = new Variant();
        $variant313->setText('Свыше 1000 грн');
        $variant313->setValue(1);
        $variant313->setQuestion($this->getReference('question-31'));
        $this->addReference('variant-31-3', $variant313);
        $manager->persist($variant313);

        $variant314 = new Variant();
        $variant314->setText('Нужно сообщать о любой сумме личных средств');
        $variant314->setValue(0);
        $variant314->setQuestion($this->getReference('question-31'));
        $this->addReference('variant-31-4', $variant314);
        $manager->persist($variant314);

        $variant321 = new Variant();
        $variant321->setText('Документ, удостоверяющий личность (паспорт, права)');
        $variant321->setValue(1);
        $variant321->setQuestion($this->getReference('question-32'));
        $this->addReference('variant-32-1', $variant321);
        $manager->persist($variant321);

        $variant322 = new Variant();
        $variant322->setText('Договор мат. Ответственности');
        $variant322->setValue(1);
        $variant322->setQuestion($this->getReference('question-32'));
        $this->addReference('variant-32-2', $variant322);
        $manager->persist($variant322);

        $variant323 = new Variant();
        $variant323->setText('Служебное удостоверение');
        $variant323->setValue(1);
        $variant323->setQuestion($this->getReference('question-32'));
        $this->addReference('variant-32-3', $variant323);
        $manager->persist($variant323);

        $variant324 = new Variant();
        $variant324->setText('Военный билет');
        $variant324->setValue(0);
        $variant324->setQuestion($this->getReference('question-32'));
        $this->addReference('variant-32-4', $variant324);
        $manager->persist($variant324);

        $variant325 = new Variant();
        $variant325->setText('Достаточно паспорта кассира');
        $variant325->setValue(0);
        $variant325->setQuestion($this->getReference('question-32'));
        $this->addReference('variant-32-5', $variant325);
        $manager->persist($variant325);

        $variant326 = new Variant();
        $variant326->setText('Должностная инструкция кассира');
        $variant326->setValue(1);
        $variant326->setQuestion($this->getReference('question-32'));
        $this->addReference('variant-32-6', $variant326);
        $manager->persist($variant326);

        $variant327 = new Variant();
        $variant327->setText('ID карта');
        $variant327->setValue(0);
        $variant327->setQuestion($this->getReference('question-32'));
        $this->addReference('variant-32-7', $variant327);
        $manager->persist($variant327);

        $variant328 = new Variant();
        $variant328->setText('Идентификационный код');
        $variant328->setValue(0);
        $variant328->setQuestion($this->getReference('question-32'));
        $this->addReference('variant-32-8', $variant328);
        $manager->persist($variant328);

        $variant331 = new Variant();
        $variant331->setText('5 минут');
        $variant331->setValue(0);
        $variant331->setQuestion($this->getReference('question-33'));
        $this->addReference('variant-33-1', $variant331);
        $manager->persist($variant331);

        $variant332 = new Variant();
        $variant332->setText('10 минут');
        $variant332->setValue(1);
        $variant332->setQuestion($this->getReference('question-33'));
        $this->addReference('variant-33-2', $variant332);
        $manager->persist($variant332);

        $variant333 = new Variant();
        $variant333->setText('Всегда необходимо ставить в известность сотрудников видеонаблюдения');
        $variant333->setValue(0);
        $variant333->setQuestion($this->getReference('question-33'));
        $this->addReference('variant-33-3', $variant333);
        $manager->persist($variant333);

        $variant334 = new Variant();
        $variant334->setText('20 минут');
        $variant334->setValue(0);
        $variant334->setQuestion($this->getReference('question-33'));
        $this->addReference('variant-33-4', $variant334);
        $manager->persist($variant334);

        $variant341 = new Variant();
        $variant341->setText('Если сумма более 1000 доллларов');
        $variant341->setValue(0);
        $variant341->setQuestion($this->getReference('question-34'));
        $this->addReference('variant-34-1', $variant341);
        $manager->persist($variant341);

        $variant342 = new Variant();
        $variant342->setText('Не обязательно закрывать деньги в сейф если выход не более чем на 5 минут');
        $variant342->setValue(0);
        $variant342->setQuestion($this->getReference('question-34'));
        $this->addReference('variant-34-2', $variant342);
        $manager->persist($variant342);

        $variant343 = new Variant();
        $variant343->setText('Если сумма более 500 доллларов');
        $variant343->setValue(0);
        $variant343->setQuestion($this->getReference('question-34'));
        $this->addReference('variant-34-3', $variant343);
        $manager->persist($variant343);

        $variant344 = new Variant();
        $variant344->setText('При каждом выходе с отделения деньги должны быть в сейфе');
        $variant344->setValue(1);
        $variant344->setQuestion($this->getReference('question-34'));
        $this->addReference('variant-34-4', $variant344);
        $manager->persist($variant344);

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

        /** @var \App\Entity\Question $question11 */
        $question11 = $this->getReference('question-11');
        $question11->addVariant($this->getReference('variant-500-rub'));
        $question11->addVariant($this->getReference('variant-2000-rub'));
        $question11->addVariant($this->getReference('variant-1000-rub'));
        $question11->addVariant($this->getReference('variant-5000-rub'));
        $manager->persist($question11);

        /** @var \App\Entity\Question $question12 */
        $question12 = $this->getReference('question-12');
        $question12->addVariant($this->getReference('variant-uah'));
        $question12->addVariant($this->getReference('variant-rub'));
        $question12->addVariant($this->getReference('variant-eur'));
        $question12->addVariant($this->getReference('variant-usd'));
        $manager->persist($question12);

        /** @var \App\Entity\Question $question13 */
        $question13 = $this->getReference('question-13');
        $question13->addVariant($this->getReference('variant-varnish'));
        $question13->addVariant($this->getReference('variant-in-the-light'));
        $question13->addVariant($this->getReference('variant-with-ultraviolet'));
        $question13->addVariant($this->getReference('variant-with-infrared'));
        $manager->persist($question13);

        /** @var \App\Entity\Question $question14 */
        $question14 = $this->getReference('question-14');
        $question14->addVariant($this->getReference('variant-right-bottom-front'));
        $question14->addVariant($this->getReference('variant-right-bottom-back'));
        $question14->addVariant($this->getReference('variant-left-bottom-front'));
        $question14->addVariant($this->getReference('variant-left-bottom-back'));
        $manager->persist($question14);

        /** @var \App\Entity\Question $question15 */
        $question15 = $this->getReference('question-15');
        $question15->addVariant($this->getReference('variant-nominal-in-digits'));
        $question15->addVariant($this->getReference('variant-portrait-collar'));
        $question15->addVariant($this->getReference('variant-usa-subscription'));
        $question15->addVariant($this->getReference('variant-nominal-in-letters'));
        $manager->persist($question15);

        /** @var \App\Entity\Question $question16 */
        $question16 = $this->getReference('question-16');
        $question16->addVariant($this->getReference('variant-usd-16'));
        $question16->addVariant($this->getReference('variant-gbp'));
        $question16->addVariant($this->getReference('variant-eur-16'));
        $question16->addVariant($this->getReference('variant-uah-16'));
        $manager->persist($question16);

        /** @var \App\Entity\Question $question17 */
        $question17 = $this->getReference('question-17');
        $question17->addVariant($this->getReference('variant-121050100'));
        $question17->addVariant($this->getReference('variant-151050100'));
        $question17->addVariant($this->getReference('variant-151020501001000'));
        $question17->addVariant($this->getReference('variant-125102050100'));
        $manager->persist($question17);

        /** @var \App\Entity\Question $question18 */
        $question18 = $this->getReference('question-18');
        $question18->addVariant($this->getReference('variant-102050100200'));
        $question18->addVariant($this->getReference('variant-102050100200500'));
        $question18->addVariant($this->getReference('variant-5102050100200'));
        $question18->addVariant($this->getReference('variant-51020501002005001000'));
        $manager->persist($question18);

        /** @var \App\Entity\Question $question19 */
        $question19 = $this->getReference('question-19');
        $question19->addVariant($this->getReference('variant-gbp-19'));
        $question19->addVariant($this->getReference('variant-eur-19'));
        $question19->addVariant($this->getReference('variant-usd-19'));
        $question19->addVariant($this->getReference('variant-pln'));
        $manager->persist($question19);

        /** @var \App\Entity\Question $question20 */
        $question20 = $this->getReference('question-20');
        $question20->addVariant($this->getReference('variant-will-not-take'));
        $question20->addVariant($this->getReference('variant-will-evaluate'));
        $question20->addVariant($this->getReference('variant-will-take-as-usual'));
        $question20->addVariant($this->getReference('variant-will-take-and-deduct'));
        $manager->persist($question20);

        /** @var \App\Entity\Question $question21 */
        $question21 = $this->getReference('question-21');
        $question21->addVariant($this->getReference('variant-21-1'));
        $question21->addVariant($this->getReference('variant-21-2'));
        $question21->addVariant($this->getReference('variant-21-3'));
        $question21->addVariant($this->getReference('variant-21-4'));
        $manager->persist($question21);

        /** @var \App\Entity\Question $question22 */
        $question22 = $this->getReference('question-22');
        $question22->addVariant($this->getReference('variant-22-1'));
        $question22->addVariant($this->getReference('variant-22-2'));
        $question22->addVariant($this->getReference('variant-22-3'));
        $question22->addVariant($this->getReference('variant-22-4'));
        $manager->persist($question22);

        /** @var \App\Entity\Question $question23 */
        $question23 = $this->getReference('question-23');
        $question23->addVariant($this->getReference('variant-23-1'));
        $question23->addVariant($this->getReference('variant-23-2'));
        $question23->addVariant($this->getReference('variant-23-3'));
        $question23->addVariant($this->getReference('variant-23-4'));
        $manager->persist($question23);

        /** @var \App\Entity\Question $question24 */
        $question24 = $this->getReference('question-24');
        $question24->addVariant($this->getReference('variant-24-1'));
        $question24->addVariant($this->getReference('variant-24-2'));
        $question24->addVariant($this->getReference('variant-24-3'));
        $question24->addVariant($this->getReference('variant-24-4'));
        $question24->addVariant($this->getReference('variant-24-5'));
        $question24->addVariant($this->getReference('variant-24-6'));
        $question24->addVariant($this->getReference('variant-24-7'));
        $question24->addVariant($this->getReference('variant-24-8'));
        $question24->addVariant($this->getReference('variant-24-9'));
        $manager->persist($question24);

        /** @var \App\Entity\Question $question25 */
        $question25 = $this->getReference('question-25');
        $question25->addVariant($this->getReference('variant-25-1'));
        $question25->addVariant($this->getReference('variant-25-2'));
        $question25->addVariant($this->getReference('variant-25-3'));
        $question25->addVariant($this->getReference('variant-25-4'));
        $question25->addVariant($this->getReference('variant-25-5'));
        $question25->addVariant($this->getReference('variant-25-6'));
        $question25->addVariant($this->getReference('variant-25-7'));
        $question25->addVariant($this->getReference('variant-25-8'));
        $question25->addVariant($this->getReference('variant-25-9'));
        $question25->addVariant($this->getReference('variant-25-10'));
        $manager->persist($question25);

        /** @var \App\Entity\Question $question26 */
        $question26 = $this->getReference('question-26');
        $question26->addVariant($this->getReference('variant-26-1'));
        $question26->addVariant($this->getReference('variant-26-2'));
        $question26->addVariant($this->getReference('variant-26-3'));
        $question26->addVariant($this->getReference('variant-26-4'));
        $question26->addVariant($this->getReference('variant-26-5'));
        $question26->addVariant($this->getReference('variant-26-6'));
        $question26->addVariant($this->getReference('variant-26-7'));
        $question26->addVariant($this->getReference('variant-26-8'));
        $manager->persist($question26);

        /** @var \App\Entity\Question $question27 */
        $question27 = $this->getReference('question-27');
        $question27->addVariant($this->getReference('variant-27-1'));
        $question27->addVariant($this->getReference('variant-27-2'));
        $question27->addVariant($this->getReference('variant-27-3'));
        $question27->addVariant($this->getReference('variant-27-4'));
        $manager->persist($question27);

        /** @var \App\Entity\Question $question28 */
        $question28 = $this->getReference('question-28');
        $question28->addVariant($this->getReference('variant-28-1'));
        $question28->addVariant($this->getReference('variant-28-2'));
        $question28->addVariant($this->getReference('variant-28-3'));
        $question28->addVariant($this->getReference('variant-28-4'));
        $manager->persist($question28);

        /** @var \App\Entity\Question $question29 */
        $question29 = $this->getReference('question-29');
        $question29->addVariant($this->getReference('variant-29-1'));
        $question29->addVariant($this->getReference('variant-29-2'));
        $question29->addVariant($this->getReference('variant-29-3'));
        $question29->addVariant($this->getReference('variant-29-4'));
        $question29->addVariant($this->getReference('variant-29-5'));
        $question29->addVariant($this->getReference('variant-29-6'));
        $question29->addVariant($this->getReference('variant-29-7'));
        $question29->addVariant($this->getReference('variant-29-8'));
        $question29->addVariant($this->getReference('variant-29-9'));
        $question29->addVariant($this->getReference('variant-29-10'));
        $manager->persist($question29);

        /** @var \App\Entity\Question $question30 */
        $question30 = $this->getReference('question-30');
        $question30->addVariant($this->getReference('variant-30-1'));
        $question30->addVariant($this->getReference('variant-30-2'));
        $question30->addVariant($this->getReference('variant-30-3'));
        $question30->addVariant($this->getReference('variant-30-4'));
        $question30->addVariant($this->getReference('variant-30-5'));
        $manager->persist($question30);

        /** @var \App\Entity\Question $question31 */
        $question31 = $this->getReference('question-31');
        $question31->addVariant($this->getReference('variant-31-1'));
        $question31->addVariant($this->getReference('variant-31-2'));
        $question31->addVariant($this->getReference('variant-31-3'));
        $question31->addVariant($this->getReference('variant-31-4'));
        $manager->persist($question31);

        /** @var \App\Entity\Question $question32 */
        $question32 = $this->getReference('question-32');
        $question32->addVariant($this->getReference('variant-32-1'));
        $question32->addVariant($this->getReference('variant-32-2'));
        $question32->addVariant($this->getReference('variant-32-3'));
        $question32->addVariant($this->getReference('variant-32-4'));
        $question32->addVariant($this->getReference('variant-32-5'));
        $question32->addVariant($this->getReference('variant-32-6'));
        $question32->addVariant($this->getReference('variant-32-7'));
        $question32->addVariant($this->getReference('variant-32-8'));
        $manager->persist($question32);

        /** @var \App\Entity\Question $question33 */
        $question33 = $this->getReference('question-33');
        $question33->addVariant($this->getReference('variant-33-1'));
        $question33->addVariant($this->getReference('variant-33-2'));
        $question33->addVariant($this->getReference('variant-33-3'));
        $question33->addVariant($this->getReference('variant-33-4'));
        $manager->persist($question33);

        /** @var \App\Entity\Question $question34 */
        $question34 = $this->getReference('question-34');
        $question34->addVariant($this->getReference('variant-34-1'));
        $question34->addVariant($this->getReference('variant-34-2'));
        $question34->addVariant($this->getReference('variant-34-3'));
        $question34->addVariant($this->getReference('variant-34-4'));
        $manager->persist($question34);

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
