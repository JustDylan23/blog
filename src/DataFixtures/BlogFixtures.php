<?php

namespace App\DataFixtures;

use App\Entity\Blog;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $blog = Blog::create()
            ->setTitle('blog 1')
            ->setContent('content 1')
        ;
        $manager->persist($blog);

        $blog = Blog::create()
            ->setTitle('blog 2')
            ->setContent('content 2')
        ;
        $manager->persist($blog);

        $manager->flush();
    }
}
