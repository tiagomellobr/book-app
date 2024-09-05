<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
    protected $faker;

    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();

        $author = $this->getReference(AuthorFixtures::AUTHOR_REFERENCE);
        $subject = $this->getReference(SubjectFixtures::SUBJECT_REFERENCE);

        $total = rand(1, 10);
        for ($i=0; $i < $total; $i++) {
            $title =  ucwords(implode(" ", $this->faker->words(3)));
            $publisher = $this->faker->company;
            $edition = $this->faker->numberBetween(1, 100);
            $year = $this->faker->year;
            $price = $this->faker->randomFloat(2, 0.01, 300);

            $book = new Book();
            $book->setTitle($title);
            $book->setPublisher($publisher);
            $book->setEdition($edition);
            $book->setPublicationYear($year);
            $book->setPrice($price);

            $book->addAuthor($author);
            $book->addSubject($subject);

            $manager->persist($book);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SubjectFixtures::class,
            AuthorFixtures::class,
        ];
    }
}
