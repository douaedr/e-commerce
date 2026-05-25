<?php
namespace App\Cart;

use App\Entity\Cart;
use App\Entity\CartItem;
use Symfony\Component\HttpFoundation\RequestStack;

class SessionCart implements CartInterface
{
    private const SESSION_KEY = 'cart';

    public function __construct(private readonly RequestStack $requestStack) {}

    private function getSession()
    {
        return $this->requestStack->getSession();
    }

    public function getCart(string $identifier): Cart
    {
        $cart = $this->getSession()->get(self::SESSION_KEY . '_' . $identifier);
        if ($cart === null) {
            $cart = new Cart();
            $cart->setCreatedAt(new \DateTime());
        }
        return $cart;
    }

    public function add(CartItem $item, Cart $cart): Cart
    {
        $identifier = $this->getSession()->getId();
        $cart->addCartItem($item);
        $this->getSession()->set(self::SESSION_KEY . '_' . $identifier, $cart);
        return $cart;
    }

    public function remove(CartItem $item, Cart $cart): Cart
    {
        $identifier = $this->getSession()->getId();
        $cart->removeCartItem($item);
        $this->getSession()->set(self::SESSION_KEY . '_' . $identifier, $cart);
        return $cart;
    }

    public function clearCart(string $identifier): void
    {
        $this->getSession()->remove(self::SESSION_KEY . '_' . $identifier);
    }
}