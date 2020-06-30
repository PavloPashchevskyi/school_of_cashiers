<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Question;

class QuestionFixture extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $question1 = new Question();
        $question1->setType(1);
        $question1->setText('Наименьшая купюра валюты евро');
        $question1->setTest($this->getReference('test-value'));
        $this->addReference('question-1', $question1);
        $manager->persist($question1);

        $question2 = new Question();
        $question2->setType(1);
        $question2->setText('Виды контроля подленности евро без использования спец техники');
        $question2->setTest($this->getReference('test-value'));
        $this->addReference('question-2', $question2);
        $manager->persist($question2);

        $question3 = new Question();
        $question3->setType(1);
        $question3->setText('На валюте евро основной рисунок никогда НЕ содержит');
        $question3->setTest($this->getReference('test-value'));
        $this->addReference('question-3', $question3);
        $manager->persist($question3);

        $question4 = new Question();
        $question4->setType(1);
        $question4->setText('Самый большой номинал валюты евро');
        $question4->setTest($this->getReference('test-value'));
        $this->addReference('question-4', $question4);
        $manager->persist($question4);

        $question5 = new Question();
        $question5->setType(1);
        $question5->setText('Кто изображен на купюре 1000 грн?');
        $question5->setTest($this->getReference('test-value'));
        $this->addReference('question-5', $question5);
        $manager->persist($question5);

        $question6 = new Question();
        $question6->setType(1);
        $question6->setText('Кто изображен на купюре 200грн?');
        $question6->setTest($this->getReference('test-value'));
        $this->addReference('question-6', $question6);
        $manager->persist($question6);

        $question7 = new Question();
        $question7->setType(1);
        $question7->setText('Что такое  OVI-знак?');
        $question7->setTest($this->getReference('test-value'));
        $this->addReference('question-7', $question7);
        $manager->persist($question7);

        $question8 = new Question();
        $question8->setType(1);
        $question8->setText('KIPP-эффект - это');
        $question8->setTest($this->getReference('test-value'));
        $this->addReference('question-8', $question8);
        $manager->persist($question8);

        $question9 = new Question();
        $question9->setType(1);
        $question9->setText('Защитная нить видна');
        $question9->setTest($this->getReference('test-value'));
        $this->addReference('question-9', $question9);
        $manager->persist($question9);

        $question10 = new Question();
        $question10->setType(1);
        $question10->setText('Что содержит KIPP-эффект  на рублях всех номиналов?');
        $question10->setTest($this->getReference('test-value'));
        $this->addReference('question-10', $question10);
        $manager->persist($question10);

        $question11 = new Question();
        $question11->setType(1);
        $question11->setText('Самый большой номинал рублей (Россия)');
        $question11->setTest($this->getReference('test-value'));
        $this->addReference('question-11', $question11);
        $manager->persist($question11);

        $question12 = new Question();
        $question12->setType(1);
        $question12->setText('Какая валюта содержит перфорацию?');
        $question12->setTest($this->getReference('test-value'));
        $this->addReference('question-12', $question12);
        $manager->persist($question12);

        $question13 = new Question();
        $question13->setType(1);
        $question13->setText('Все номиналы росийских рублей содержат эмблему банка "двуглавый орел"');
        $question13->setTest($this->getReference('test-value'));
        $this->addReference('question-13', $question13);
        $manager->persist($question13);

        $question14 = new Question();
        $question14->setType(1);
        $question14->setText('Где расположено антисканерное изображение номинала на росийских рублях?');
        $question14->setTest($this->getReference('test-value'));
        $this->addReference('question-14', $question14);
        $manager->persist($question14);

        $question15 = new Question();
        $question15->setType(1);
        $question15->setText('Что напечатанно на всех номеналах валюты доллар с помощью рельефной печати?');
        $question15->setTest($this->getReference('test-value'));
        $this->addReference('question-15', $question15);
        $manager->persist($question15);

        $question16 = new Question();
        $question16->setType(1);
        $question16->setText('Какая валюта меняет при просвете ультрафиолетом свой цвет защитной полосы в зависимости от номинала?');
        $question16->setTest($this->getReference('test-value'));
        $this->addReference('question-16', $question16);
        $manager->persist($question16);

        $question17 = new Question();
        $question17->setType(1);
        $question17->setText('Какие номиналы имеет валюта долллар?');
        $question17->setTest($this->getReference('test-value'));
        $this->addReference('question-17', $question17);
        $manager->persist($question17);

        $question18 = new Question();
        $question18->setType(1);
        $question18->setText('Какие номиналы имеют злотые?');
        $question18->setTest($this->getReference('test-value'));
        $this->addReference('question-18', $question18);
        $manager->persist($question18);

        $question19 = new Question();
        $question19->setType(1);
        $question19->setText('Какая валюта на всех номиналах имеет двухстороннюю печать (полное изображение видно на просвет при совмещении рисунка) в виде короны?');
        $question19->setTest($this->getReference('test-value'));
        $this->addReference('question-19', $question19);
        $manager->persist($question19);

        $question20 = new Question();
        $question20->setType(1);
        $question20->setText('Как Вы будете действовать при получении ветхой купюры?');
        $question20->setTest($this->getReference('test-value'));
        $this->addReference('question-20', $question20);
        $manager->persist($question20);

        $manager->flush();

    }

    public function getOrder()
    {
        return 2;
    }
}
