<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200918160810 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE composition DROP FOREIGN KEY FK_C7F4347A76ED395');
        $this->addSql('DROP INDEX IDX_C7F4347A76ED395 ON composition');
        $this->addSql('ALTER TABLE composition CHANGE composition_user_id composition_user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE composition ADD CONSTRAINT FK_C7F4347C863CF3 FOREIGN KEY (composition_user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C7F4347C863CF3 ON composition (composition_user_id_id)');
        $this->addSql('DROP INDEX IDX_C7F4347A76ED395 ON score');
        $this->addSql('ALTER TABLE score CHANGE score_user_id score_user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_329937516C0CAEB7 FOREIGN KEY (score_user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_329937516C0CAEB7 ON score (score_user_id_id)');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(180) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE composition DROP FOREIGN KEY FK_C7F4347C863CF3');
        $this->addSql('DROP INDEX IDX_C7F4347C863CF3 ON composition');
        $this->addSql('ALTER TABLE composition CHANGE composition_user_id_id composition_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE composition ADD CONSTRAINT FK_C7F4347A76ED395 FOREIGN KEY (composition_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C7F4347A76ED395 ON composition (composition_user_id)');
        $this->addSql('ALTER TABLE score DROP FOREIGN KEY FK_329937516C0CAEB7');
        $this->addSql('DROP INDEX IDX_329937516C0CAEB7 ON score');
        $this->addSql('ALTER TABLE score CHANGE score_user_id_id score_user_id INT NOT NULL');
        $this->addSql('CREATE INDEX IDX_C7F4347A76ED395 ON score (score_user_id)');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(250) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(250) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
