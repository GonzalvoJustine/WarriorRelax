<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211105210505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exercise_domain (exercise_id INT NOT NULL, domain_id INT NOT NULL, INDEX IDX_D2E68B60E934951A (exercise_id), INDEX IDX_D2E68B60115F0EE5 (domain_id), PRIMARY KEY(exercise_id, domain_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session_domain (session_id INT NOT NULL, domain_id INT NOT NULL, INDEX IDX_C8C21452613FECDF (session_id), INDEX IDX_C8C21452115F0EE5 (domain_id), PRIMARY KEY(session_id, domain_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exercise_domain ADD CONSTRAINT FK_D2E68B60E934951A FOREIGN KEY (exercise_id) REFERENCES exercise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercise_domain ADD CONSTRAINT FK_D2E68B60115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE session_domain ADD CONSTRAINT FK_C8C21452613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE session_domain ADD CONSTRAINT FK_C8C21452115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE domain_exercise');
        $this->addSql('DROP TABLE domain_session');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE domain_exercise (domain_id INT NOT NULL, exercise_id INT NOT NULL, INDEX IDX_BD549A53115F0EE5 (domain_id), INDEX IDX_BD549A53E934951A (exercise_id), PRIMARY KEY(domain_id, exercise_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE domain_session (domain_id INT NOT NULL, session_id INT NOT NULL, INDEX IDX_3293CCCC115F0EE5 (domain_id), INDEX IDX_3293CCCC613FECDF (session_id), PRIMARY KEY(domain_id, session_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE domain_exercise ADD CONSTRAINT FK_BD549A53115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE domain_exercise ADD CONSTRAINT FK_BD549A53E934951A FOREIGN KEY (exercise_id) REFERENCES exercise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE domain_session ADD CONSTRAINT FK_3293CCCC115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE domain_session ADD CONSTRAINT FK_3293CCCC613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE exercise_domain');
        $this->addSql('DROP TABLE session_domain');
    }
}
