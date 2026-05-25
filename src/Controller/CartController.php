<?php
namespace App\Controller;

use App\Cart\CartHandler;
use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    public function __construct(private CartHandler $cartHandler) {}

    #[Route('/cart', name: 'app_cart')]
    public function index(Request $request): Response
    {
        $identifier = $request->getSession()->getId();
        $cart = $this->cartHandler->getCart($identifier);

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add', methods: ['POST'])]
    public function add(Product $product, Request $request): Response
    {
        $identifier = $request->getSession()->getId();
        $cart = $this->cartHandler->getCart($identifier);

        $quantity = $request->request->getInt('quantity', 1);

        $cartItem = new CartItem();
        $cartItem->setProduct($product);
        $cartItem->setPrice((float) $product->getPrice());
        $cartItem->setQuantity($quantity);

        $this->cartHandler->add($cartItem, $cart);

        $this->addFlash('success', '"' . $product->getName() . '" ajouté au panier !');
        return $this->redirectToRoute('app_product_details', ['id' => $product->getId()]);
    }

    #[Route('/cart/remove/{id}', name: 'app_cart_remove', methods: ['POST'])]
    public function remove(Request $request, int $id): Response
    {
        $identifier = $request->getSession()->getId();
        $cart = $this->cartHandler->getCart($identifier);

        foreach ($cart->getCartItems() as $item) {
            if ($item->getProduct()->getId() === $id) {
                $this->cartHandler->remove($item, $cart);
                break;
            }
        }

        $this->addFlash('success', 'Produit supprimé.');
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/clear', name: 'app_cart_clear', methods: ['POST'])]
    public function clear(Request $request): Response
    {
        $identifier = $request->getSession()->getId();
        $this->cartHandler->clearCart($identifier);
        $this->addFlash('success', 'Panier vidé.');
        return $this->redirectToRoute('app_cart');
    }
}