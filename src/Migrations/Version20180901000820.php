<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180901000820 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE candidate ADD curp VARCHAR(18) NOT NULL, ADD rfc VARCHAR(13) NOT NULL, ADD nss VARCHAR(11) NOT NULL, ADD children LONGTEXT DEFAULT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE address address VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE company CHANGE phone phone VARCHAR(20) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE rfc rfc VARCHAR(13) NOT NULL, CHANGE address address VARCHAR(255) NOT NULL, CHANGE contact contact VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE candidate DROP curp, DROP rfc, DROP nss, DROP children, CHANGE email email VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE address address VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE company CHANGE phone phone VARCHAR(20) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE email email VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE rfc rfc VARCHAR(13) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE address address VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE contact contact VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
