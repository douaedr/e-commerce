<?php
namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'app_product_list')]
    public function list(ProductRepository $productRepository): Response
    {
        return $this->render('product/list.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/product/{id}', name: 'app_product_details')]
    public function details(Product $product): Response
    {
        return $this->render('product/details.html.twig', [
            'product' => $product,
        ]);
    }
}