<?php
namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'app_category_browse')]
    public function browse(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/browse.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/category/{id}', name: 'app_category_products')]
    public function products(Category $category): Response
    {
        return $this->render('category/products.html.twig', [
            'category' => $category,
            'products' => $category->getProducts(),
        ]);
    }
}