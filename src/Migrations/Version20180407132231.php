<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180407132231 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE dinosaur (id INT AUTO_INCREMENT NOT NULL, enclosure_id INT DEFAULT NULL, length INT NOT NULL, genus VARCHAR(255) NOT NULL, is_carnivorous TINYINT(1) NOT NULL, INDEX IDX_DAEDC56ED04FE1E5 (enclosure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enclosure (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE security (id INT AUTO_INCREMENT NOT NULL, enclosure_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_C59BD5C1D04FE1E5 (enclosure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dinosaur ADD CONSTRAINT FK_DAEDC56ED04FE1E5 FOREIGN KEY (enclosure_id) REFERENCES enclosure (id)');
        $this->addSql('ALTER TABLE security ADD CONSTRAINT FK_C59BD5C1D04FE1E5 FOREIGN KEY (enclosure_id) REFERENCES enclosure (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE dinosaur DROP FOREIGN KEY FK_DAEDC56ED04FE1E5');
        $this->addSql('ALTER TABLE security DROP FOREIGN KEY FK_C59BD5C1D04FE1E5');
        $this->addSql('DROP TABLE dinosaur');
        $this->addSql('DROP TABLE enclosure');
        $this->addSql('DROP TABLE security');
    }
}
