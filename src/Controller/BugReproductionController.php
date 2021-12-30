<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Blog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class BugReproductionController extends AbstractController
{
    #[Route('/bug')]
    public function test(DenormalizerInterface $denormalizer) {
        $blog = $denormalizer->denormalize([
            'title' => 'test title',
            'author' => 'test string',
        ], Blog::class);

        dd($blog);
    }
}
