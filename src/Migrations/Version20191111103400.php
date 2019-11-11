<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191111103400 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE advert (id INT AUTO_INCREMENT NOT NULL, advert_user_id_id INT NOT NULL, advert_title VARCHAR(50) NOT NULL, advert_price DOUBLE PRECISION NOT NULL, advert_description LONGTEXT NOT NULL, advert_photo LONGTEXT DEFAULT NULL, advert_date DATETIME NOT NULL, advert_localisation VARCHAR(100) NOT NULL, advert_category VARCHAR(30) NOT NULL, advert_region VARCHAR(50) NOT NULL, INDEX IDX_54F1F40B94AA1435 (advert_user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE advert ADD CONSTRAINT FK_54F1F40B94AA1435 FOREIGN KEY (advert_user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user CHANGE password password VARCHAR(30) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE advert');
        $this->addSql('ALTER TABLE user CHANGE password password VARCHAR(60) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
