<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191129175603 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE clothe (id INT AUTO_INCREMENT NOT NULL, clothe_advert_id INT NOT NULL, clothe_type VARCHAR(50) NOT NULL, clothe_brand VARCHAR(50) NOT NULL, clothe_color VARCHAR(50) DEFAULT NULL, clothe_state VARCHAR(30) NOT NULL, clothe_universe VARCHAR(20) NOT NULL, UNIQUE INDEX UNIQ_C32115BA2A4896BB (clothe_advert_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE clothe ADD CONSTRAINT FK_C32115BA2A4896BB FOREIGN KEY (clothe_advert_id) REFERENCES advert (id)');
        $this->addSql('ALTER TABLE immovable DROP FOREIGN KEY FK_42F2DAA9E61E82B');
        $this->addSql('DROP INDEX UNIQ_42F2DAA9E61E82B ON immovable');
        $this->addSql('ALTER TABLE immovable CHANGE immovable_advert_id_id immovable_advert_id INT NOT NULL');
        $this->addSql('ALTER TABLE immovable ADD CONSTRAINT FK_42F2DAA843FC6AE FOREIGN KEY (immovable_advert_id) REFERENCES advert (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_42F2DAA843FC6AE ON immovable (immovable_advert_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE clothe');
        $this->addSql('ALTER TABLE immovable DROP FOREIGN KEY FK_42F2DAA843FC6AE');
        $this->addSql('DROP INDEX UNIQ_42F2DAA843FC6AE ON immovable');
        $this->addSql('ALTER TABLE immovable CHANGE immovable_advert_id immovable_advert_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE immovable ADD CONSTRAINT FK_42F2DAA9E61E82B FOREIGN KEY (immovable_advert_id_id) REFERENCES advert (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_42F2DAA9E61E82B ON immovable (immovable_advert_id_id)');
    }
}
