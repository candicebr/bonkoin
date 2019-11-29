<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191129154648 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE immovable (id INT AUTO_INCREMENT NOT NULL, immovable_advert_id_id INT NOT NULL, immovable_type VARCHAR(20) NOT NULL, immovable_surface DOUBLE PRECISION NOT NULL, immovable_room INT NOT NULL, immovable_energy VARCHAR(1) DEFAULT NULL, UNIQUE INDEX UNIQ_42F2DAA9E61E82B (immovable_advert_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE immovable ADD CONSTRAINT FK_42F2DAA9E61E82B FOREIGN KEY (immovable_advert_id_id) REFERENCES advert (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE immovable');
    }
}
