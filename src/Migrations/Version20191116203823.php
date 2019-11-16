<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191116203823 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, advert_id INT NOT NULL, INDEX IDX_AC6340B3A76ED395 (user_id), INDEX IDX_AC6340B3D07ECCB6 (advert_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3D07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id)');
        $this->addSql('ALTER TABLE advert RENAME INDEX idx_54f1f40b94aa1435 TO IDX_54F1F40BD2093C3');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE `like`');
        $this->addSql('ALTER TABLE advert RENAME INDEX idx_54f1f40bd2093c3 TO IDX_54F1F40B94AA1435');
    }
}
