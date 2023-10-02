<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230929115817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE session_student (session_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_A5FB2D69613FECDF (session_id), INDEX IDX_A5FB2D69CB944F1A (student_id), PRIMARY KEY(session_id, student_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE session_student ADD CONSTRAINT FK_A5FB2D69613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE session_student ADD CONSTRAINT FK_A5FB2D69CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_session DROP FOREIGN KEY FK_3D72602C613FECDF');
        $this->addSql('ALTER TABLE student_session DROP FOREIGN KEY FK_3D72602CCB944F1A');
        $this->addSql('DROP TABLE student_session');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE student_session (student_id INT NOT NULL, session_id INT NOT NULL, INDEX IDX_3D72602CCB944F1A (student_id), INDEX IDX_3D72602C613FECDF (session_id), PRIMARY KEY(student_id, session_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE student_session ADD CONSTRAINT FK_3D72602C613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_session ADD CONSTRAINT FK_3D72602CCB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE session_student DROP FOREIGN KEY FK_A5FB2D69613FECDF');
        $this->addSql('ALTER TABLE session_student DROP FOREIGN KEY FK_A5FB2D69CB944F1A');
        $this->addSql('DROP TABLE session_student');
    }
}
