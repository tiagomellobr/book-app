<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240829124138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE VIEW author_books_subjects AS
            SELECT
                a.id,
                a.name AS author_name,
                COUNT(DISTINCT b.id) as total_books,
                GROUP_CONCAT(DISTINCT b.title SEPARATOR ', ') AS books,
                GROUP_CONCAT(DISTINCT s.description SEPARATOR ', ') AS subjects
            FROM
                author a
            INNER JOIN book_author ba ON
                a.id = ba.author_id
            INNER JOIN book b ON
                ba.book_id = b.id
            INNER JOIN book_subject bs ON
                b.id = bs.book_id
            INNER JOIN subject s ON
                bs.subject_id = s.id
            GROUP BY
                a.id"
        );

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP VIEW app.author_books_subjects');

    }
}
