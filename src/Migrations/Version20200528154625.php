<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200528154625 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE percussion (id INT AUTO_INCREMENT NOT NULL, note_id INT NOT NULL, movement_id INT NOT NULL, INDEX IDX_C4622B1726ED0855 (note_id), INDEX IDX_C4622B17229E70A7 (movement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movement (id INT AUTO_INCREMENT NOT NULL, word_to_sing VARCHAR(255) NOT NULL, sound VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE composition (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE composition_percussion (composition_id INT NOT NULL, percussion_id INT NOT NULL, INDEX IDX_556272EB87A2E12 (composition_id), INDEX IDX_556272EBAAE48D1C (percussion_id), PRIMARY KEY(composition_id, percussion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movement_image (id INT AUTO_INCREMENT NOT NULL, movement_id INT NOT NULL, source VARCHAR(255) NOT NULL, INDEX IDX_3887D34A229E70A7 (movement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, duration INT NOT NULL, note_image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE percussion ADD CONSTRAINT FK_C4622B1726ED0855 FOREIGN KEY (note_id) REFERENCES note (id)');
        $this->addSql('ALTER TABLE percussion ADD CONSTRAINT FK_C4622B17229E70A7 FOREIGN KEY (movement_id) REFERENCES movement (id)');
        $this->addSql('ALTER TABLE composition_percussion ADD CONSTRAINT FK_556272EB87A2E12 FOREIGN KEY (composition_id) REFERENCES composition (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE composition_percussion ADD CONSTRAINT FK_556272EBAAE48D1C FOREIGN KEY (percussion_id) REFERENCES percussion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movement_image ADD CONSTRAINT FK_3887D34A229E70A7 FOREIGN KEY (movement_id) REFERENCES movement (id)');
        
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE composition_percussion DROP FOREIGN KEY FK_556272EBAAE48D1C');
        $this->addSql('ALTER TABLE percussion DROP FOREIGN KEY FK_C4622B17229E70A7');
        $this->addSql('ALTER TABLE movement_image DROP FOREIGN KEY FK_3887D34A229E70A7');
        $this->addSql('ALTER TABLE composition_percussion DROP FOREIGN KEY FK_556272EB87A2E12');
        $this->addSql('ALTER TABLE percussion DROP FOREIGN KEY FK_C4622B1726ED0855');
        $this->addSql('DROP TABLE percussion');
        $this->addSql('DROP TABLE movement');
        $this->addSql('DROP TABLE composition');
        $this->addSql('DROP TABLE composition_percussion');
        $this->addSql('DROP TABLE movement_image');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE user');
    }
}
