<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180913171916 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('INSERT INTO audit_status (`name`) VALUES (\'Abierta\')');
        $this->addSql('INSERT INTO audit_status (`name`) VALUES (\'Asignada\')');
        $this->addSql('INSERT INTO audit_status (`name`) VALUES (\'Pendiente por realizar visita\')');
        $this->addSql('INSERT INTO audit_status (`name`) VALUES (\'Pendiente por realizar prueba\')');
        $this->addSql('INSERT INTO audit_status (`name`) VALUES (\'En curso\')');
        $this->addSql('INSERT INTO audit_status (`name`) VALUES (\'Concluida\')');
        $this->addSql('INSERT INTO audit_status (`name`) VALUES (\'Cancelada\')');

    }

    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('SET FOREIGN_KEY_CHECKS=0');
        $this->addSql('TRUNCATE TABLE civil_status');
        $this->addSql('SET FOREIGN_KEY_CHECKS=1');

    }
}
