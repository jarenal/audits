<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180831162806 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE civil_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidate ADD civil_status_id INT DEFAULT NULL, ADD address VARCHAR(255) DEFAULT NULL, ADD birth DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE candidate ADD CONSTRAINT FK_C8B28E4496DE64FD FOREIGN KEY (civil_status_id) REFERENCES civil_status (id)');
        $this->addSql('CREATE INDEX IDX_C8B28E4496DE64FD ON candidate (civil_status_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE candidate DROP FOREIGN KEY FK_C8B28E4496DE64FD');
        $this->addSql('DROP TABLE civil_status');
        $this->addSql('DROP INDEX IDX_C8B28E4496DE64FD ON candidate');
        $this->addSql('ALTER TABLE candidate DROP civil_status_id, DROP address, DROP birth');
    }
}
