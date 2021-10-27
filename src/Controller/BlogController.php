<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\BlogRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blogs', name: 'blog_list')]
    public function list(BlogRepository $blogRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $query = $blogRepository->getPaginationQueryBuilder();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            40 // limit per page
        );

        $pagination->setCustomParameters(['align' => 'center']);

        return $this->render('content/blog/views/list.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/blogs/{id<\d+>}', name: 'blog_detail')]
    public function detail(int $id, BlogRepository $blogRepository): Response
    {
        $blog = $blogRepository->find($id);

        if ($blog === null) {
            throw $this->createNotFoundException("Blog with id {$id} not found");
        }

        return $this->render('content/blog/views/detail.html.twig', [
            'blog' => $blog,
        ]);
    }
}
