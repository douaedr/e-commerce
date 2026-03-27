<?php
namespace App\Controller;

use App\Cart\CartHandler;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    public function __construct(private CartHandler $cartHandler) {}

    #[Route('/cart', name: 'app_cart')]
    public function index(ProductRepository $productRepository): Response
    {
        $cartItems = $this->cartHandler->getItems();
        $items = [];
        $total = 0;

        foreach ($cartItems as $productId => $quantity) {
            $product = $productRepository->find($productId);
            if ($product) {
                $subtotal = $product->getPrice() * $quantity;
                $total += $subtotal;
                $items[] = [
                    'product'  => $product,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ];
            }
        }

        return $this->render('cart/index.html.twig', [
            'items' => $items,
            'total' => $total,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add', methods: ['POST'])]
    public function add(Product $product, Request $request): Response
    {
        $quantity = $request->request->getInt('quantity', 1);
        $this->cartHandler->add($product->getId(), $quantity);
        $this->addFlash('success', '"' . $product->getName() . '" ajouté au panier !');
        return $this->redirectToRoute('app_product_details', ['id' => $product->getId()]);
    }

    #[Route('/cart/remove/{id}', name: 'app_cart_remove', methods: ['POST'])]
    public function remove(int $id): Response
    {
        $this->cartHandler->remove($id);
        $this->addFlash('success', 'Produit supprimé.');
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/clear', name: 'app_cart_clear', methods: ['POST'])]
    public function clear(): Response
    {
        $this->cartHandler->clear();
        $this->addFlash('success', 'Panier vidé.');
        return $this->redirectToRoute('app_cart');
    }
}