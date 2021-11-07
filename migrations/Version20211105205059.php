<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211105205059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_domain (category_id INT NOT NULL, domain_id INT NOT NULL, INDEX IDX_A841D47012469DE2 (category_id), INDEX IDX_A841D470115F0EE5 (domain_id), PRIMARY KEY(category_id, domain_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE domain (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_domain ADD CONSTRAINT FK_A841D47012469DE2 FOREIGN KEY (category_id) REFERENCES test (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_domain ADD CONSTRAINT FK_A841D470115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE test DROP term');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_domain DROP FOREIGN KEY FK_A841D470115F0EE5');
        $this->addSql('DROP TABLE category_domain');
        $this->addSql('DROP TABLE domain');
        $this->addSql('ALTER TABLE test ADD term VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
