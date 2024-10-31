<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241031130348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP CONSTRAINT fk_c744045567b3b43d');
        $this->addSql('DROP INDEX uniq_c744045567b3b43d');
        $this->addSql('ALTER TABLE client DROP users_id');
        $this->addSql('ALTER TABLE "user" ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER login TYPE VARCHAR(180)');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D64919EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64919EB6921 ON "user" (client_id)');
        $this->addSql('ALTER INDEX uniq_8d93d649aa08cb10 RENAME TO UNIQ_IDENTIFIER_LOGIN');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE client ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT fk_c744045567b3b43d FOREIGN KEY (users_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_c744045567b3b43d ON client (users_id)');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D64919EB6921');
        $this->addSql('DROP INDEX UNIQ_8D93D64919EB6921');
        $this->addSql('ALTER TABLE "user" DROP client_id');
        $this->addSql('ALTER TABLE "user" DROP roles');
        $this->addSql('ALTER TABLE "user" ALTER login TYPE VARCHAR(100)');
        $this->addSql('ALTER INDEX uniq_identifier_login RENAME TO uniq_8d93d649aa08cb10');
    }
}
