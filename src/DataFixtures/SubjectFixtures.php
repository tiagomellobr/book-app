<?php

namespace App\DataFixtures;

use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SubjectFixtures extends Fixture
{
    public const SUBJECT_REFERENCE = 'subject';

    protected $faker;

    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();

        $description = $this->faker->word;

        $subject = new Subject();
        $subject->setDescription($description);
        $manager->persist($subject);

        $manager->flush();

        $this->addReference(self::SUBJECT_REFERENCE, $subject);
    }
}
