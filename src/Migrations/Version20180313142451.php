<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180313142451 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE score_comment ADD score_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE score_comment ADD CONSTRAINT FK_F5FC77F812EB0A51 FOREIGN KEY (score_id) REFERENCES score (id)');
        $this->addSql('CREATE INDEX IDX_F5FC77F812EB0A51 ON score_comment (score_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE score_comment DROP FOREIGN KEY FK_F5FC77F812EB0A51');
        $this->addSql('DROP INDEX IDX_F5FC77F812EB0A51 ON score_comment');
        $this->addSql('ALTER TABLE score_comment DROP score_id');
    }
}
