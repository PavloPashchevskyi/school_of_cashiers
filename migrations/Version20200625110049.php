<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200625110049 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attempt (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, test_id INT NOT NULL, number_of_points SMALLINT NOT NULL, start_timestamp INT NOT NULL, end_timestamp INT NOT NULL, INDEX IDX_18EC0266A76ED395 (user_id), INDEX IDX_18EC02661E5D0459 (test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attempt ADD CONSTRAINT FK_18EC0266A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE attempt ADD CONSTRAINT FK_18EC02661E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE attempt');
    }
}
