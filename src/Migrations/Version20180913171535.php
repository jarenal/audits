<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180913171535 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE audit_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE audit (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', company_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', candidate_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', agent_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', status_id INT NOT NULL, required_position VARCHAR(255) NOT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, is_deleted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_9218FF79979B1AD6 (company_id), INDEX IDX_9218FF7991BD8781 (candidate_id), INDEX IDX_9218FF793414710B (agent_id), INDEX IDX_9218FF796BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE audit ADD CONSTRAINT FK_9218FF79979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE audit ADD CONSTRAINT FK_9218FF7991BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id)');
        $this->addSql('ALTER TABLE audit ADD CONSTRAINT FK_9218FF793414710B FOREIGN KEY (agent_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE audit ADD CONSTRAINT FK_9218FF796BF700BD FOREIGN KEY (status_id) REFERENCES audit_status (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE audit DROP FOREIGN KEY FK_9218FF796BF700BD');
        $this->addSql('DROP TABLE audit_status');
        $this->addSql('DROP TABLE audit');
    }
}
