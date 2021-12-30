<?php

namespace App\DataFixtures;

use App\Entity\Blog;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BlogFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $blog = Blog::create()
            ->setTitle('blog 1')
            ->setContent('content 1')
            ->setAuthor($this->getReference(UserFixtures::USER_1_REFERENCE))
        ;
        $manager->persist($blog);

        $blog = Blog::create()
            ->setTitle('blog 2')
            ->setContent('content 2')
            ->setAuthor($this->getReference(UserFixtures::USER_1_REFERENCE))
        ;
        $manager->persist($blog);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
