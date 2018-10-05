<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181002114840 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE question_option (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, text VARCHAR(100) NOT NULL, is_valid TINYINT(1) NOT NULL, INDEX IDX_5DDB2FB81E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, text VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_quiz (question_id INT NOT NULL, quiz_id INT NOT NULL, INDEX IDX_FAFC177D1E27F6BF (question_id), INDEX IDX_FAFC177D853CD175 (quiz_id), PRIMARY KEY(question_id, quiz_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(100) NOT NULL, username VARCHAR(50) NOT NULL, is_active TINYINT(1) NOT NULL, name VARCHAR(50) NOT NULL, surname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, role LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, quiz_id INT DEFAULT NULL, time_start DATETIME NOT NULL, tine_end DATETIME DEFAULT NULL, score SMALLINT DEFAULT NULL, INDEX IDX_232B318C853CD175 (quiz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, create_data DATETIME NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE answers (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, is_valid TINYINT(1) NOT NULL, INDEX IDX_50D0C6061E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE answers_game (answers_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_955A6D8979BF1BCE (answers_id), INDEX IDX_955A6D89E48FD905 (game_id), PRIMARY KEY(answers_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE question_option ADD CONSTRAINT FK_5DDB2FB81E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE question_quiz ADD CONSTRAINT FK_FAFC177D1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_quiz ADD CONSTRAINT FK_FAFC177D853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE answers ADD CONSTRAINT FK_50D0C6061E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE answers_game ADD CONSTRAINT FK_955A6D8979BF1BCE FOREIGN KEY (answers_id) REFERENCES answers (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE answers_game ADD CONSTRAINT FK_955A6D89E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE question_option DROP FOREIGN KEY FK_5DDB2FB81E27F6BF');
        $this->addSql('ALTER TABLE question_quiz DROP FOREIGN KEY FK_FAFC177D1E27F6BF');
        $this->addSql('ALTER TABLE answers DROP FOREIGN KEY FK_50D0C6061E27F6BF');
        $this->addSql('ALTER TABLE answers_game DROP FOREIGN KEY FK_955A6D89E48FD905');
        $this->addSql('ALTER TABLE question_quiz DROP FOREIGN KEY FK_FAFC177D853CD175');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C853CD175');
        $this->addSql('ALTER TABLE answers_game DROP FOREIGN KEY FK_955A6D8979BF1BCE');
        $this->addSql('DROP TABLE question_option');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE question_quiz');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE answers');
        $this->addSql('DROP TABLE answers_game');
    }
}
