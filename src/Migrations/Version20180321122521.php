<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180321122521 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fortune_cookie (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, fortune VARCHAR(255) NOT NULL, createdAt DATETIME NOT NULL, numberPrinted INT NOT NULL, discontinued TINYINT(1) NOT NULL, INDEX IDX_F8D8B48712469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE score (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, real_name VARCHAR(100) NOT NULL, score INT NOT NULL, is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_329937515E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, tall INT NOT NULL, weight INT NOT NULL, is_active TINYINT(1) NOT NULL, born DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, iconKey VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE score_comment (id INT AUTO_INCREMENT NOT NULL, score_id INT NOT NULL, name VARCHAR(255) NOT NULL, comment LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_F5FC77F812EB0A51 (score_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fortune_cookie ADD CONSTRAINT FK_F8D8B48712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE score_comment ADD CONSTRAINT FK_F5FC77F812EB0A51 FOREIGN KEY (score_id) REFERENCES score (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE score_comment DROP FOREIGN KEY FK_F5FC77F812EB0A51');
        $this->addSql('ALTER TABLE fortune_cookie DROP FOREIGN KEY FK_F8D8B48712469DE2');
        $this->addSql('DROP TABLE fortune_cookie');
        $this->addSql('DROP TABLE score');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE score_comment');
    }
}
