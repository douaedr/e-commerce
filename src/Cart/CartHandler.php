<?php
namespace App\Cart;

use App\Entity\Cart;
use App\Entity\CartItem;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class CartHandler
{
    public function __construct(
        #[Autowire(service: SessionCart::class)]
        private CartInterface $cart
    ) {}

    public function add(CartItem $item, Cart $cart): Cart
    {
        return $this->cart->add($item, $cart);
    }

    public function remove(CartItem $item, Cart $cart): Cart
    {
        return $this->cart->remove($item, $cart);
    }

    public function getCart(string $identifier): Cart
    {
        return $this->cart->getCart($identifier);
    }

    public function clearCart(string $identifier): void
    {
        $this->cart->clearCart($identifier);
    }
}