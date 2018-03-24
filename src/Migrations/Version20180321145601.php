<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180321145601 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_company DROP FOREIGN KEY FK_17B2174567B3B43D');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, tall INT NOT NULL, weight INT NOT NULL, is_active TINYINT(1) NOT NULL, born DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, is_ever_working TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP INDEX IDX_17B2174567B3B43D ON user_company');
        $this->addSql('ALTER TABLE user_company DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user_company CHANGE users_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_company ADD CONSTRAINT FK_17B21745A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_17B21745A76ED395 ON user_company (user_id)');
        $this->addSql('ALTER TABLE user_company ADD PRIMARY KEY (user_id, company_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_company DROP FOREIGN KEY FK_17B21745A76ED395');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, region VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, tall INT NOT NULL, weight INT NOT NULL, is_active TINYINT(1) NOT NULL, born DATETIME NOT NULL, slug VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, is_ever_working TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_17B21745A76ED395 ON user_company');
        $this->addSql('ALTER TABLE user_company DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user_company CHANGE user_id users_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_company ADD CONSTRAINT FK_17B2174567B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_17B2174567B3B43D ON user_company (users_id)');
        $this->addSql('ALTER TABLE user_company ADD PRIMARY KEY (users_id, company_id)');
    }
}
