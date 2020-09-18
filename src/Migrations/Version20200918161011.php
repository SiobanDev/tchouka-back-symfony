<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200918161011 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE composition DROP FOREIGN KEY FK_C7F4347C863CF3');
        $this->addSql('DROP INDEX IDX_C7F4347C863CF3 ON composition');
        $this->addSql('ALTER TABLE composition CHANGE composition_user_id_id composition_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE composition ADD CONSTRAINT FK_C7F4347BA19C4ED FOREIGN KEY (composition_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C7F4347BA19C4ED ON composition (composition_user_id)');
        $this->addSql('ALTER TABLE score DROP FOREIGN KEY FK_329937516C0CAEB7');
        $this->addSql('DROP INDEX IDX_329937516C0CAEB7 ON score');
        $this->addSql('ALTER TABLE score CHANGE score_user_id_id score_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_32993751C6E6F601 FOREIGN KEY (score_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_32993751C6E6F601 ON score (score_user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE composition DROP FOREIGN KEY FK_C7F4347BA19C4ED');
        $this->addSql('DROP INDEX IDX_C7F4347BA19C4ED ON composition');
        $this->addSql('ALTER TABLE composition CHANGE composition_user_id composition_user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE composition ADD CONSTRAINT FK_C7F4347C863CF3 FOREIGN KEY (composition_user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C7F4347C863CF3 ON composition (composition_user_id_id)');
        $this->addSql('ALTER TABLE score DROP FOREIGN KEY FK_32993751C6E6F601');
        $this->addSql('DROP INDEX IDX_32993751C6E6F601 ON score');
        $this->addSql('ALTER TABLE score CHANGE score_user_id score_user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_329937516C0CAEB7 FOREIGN KEY (score_user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_329937516C0CAEB7 ON score (score_user_id_id)');
    }
}
