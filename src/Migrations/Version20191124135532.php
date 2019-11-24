<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191124135532 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, like_user_id INT NOT NULL, like_advert_id INT NOT NULL, INDEX IDX_AC6340B3F4E399B6 (like_user_id), INDEX IDX_AC6340B3F8DE40D4 (like_advert_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3F4E399B6 FOREIGN KEY (like_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3F8DE40D4 FOREIGN KEY (like_advert_id) REFERENCES advert (id)');
        $this->addSql('ALTER TABLE advert ADD advert_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE advert ADD CONSTRAINT FK_54F1F40BD2093C3 FOREIGN KEY (advert_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_54F1F40BD2093C3 ON advert (advert_user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE `like`');
        $this->addSql('ALTER TABLE advert DROP FOREIGN KEY FK_54F1F40BD2093C3');
        $this->addSql('DROP INDEX IDX_54F1F40BD2093C3 ON advert');
        $this->addSql('ALTER TABLE advert DROP advert_user_id');
    }
}
