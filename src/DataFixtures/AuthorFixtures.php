<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AuthorFixtures extends Fixture
{
    public const AUTHOR_REFERENCE = 'author';

    protected $faker;
    
    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();

        $fullName = $this->faker->firstName . ' ' . $this->faker->lastName;
        $author = new Author();
        $author->setName($fullName);

        $manager->persist($author);

        $manager->flush();

        $this->addReference(self::AUTHOR_REFERENCE, $author);
    }
}
