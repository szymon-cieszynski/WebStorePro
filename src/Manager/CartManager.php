<?php

namespace App\Manager;

use App\Entity\Order;
use App\Factory\OrderFactory;
use App\Storage\CartSessionStorage;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class CartManager
 * @package App\Manager
 */
class CartManager
{
    private CartSessionStorage $cartSessionStorage;

    private OrderFactory $cartFactory;

    private EntityManager $entityManager;

    private Security $security;

    // private Order $total;

    /**
     * CartManager constructor
     */
    public function __construct(
        CartSessionStorage $cartStorage,
        OrderFactory $orderFactory,
        EntityManagerInterface $entityManager,
        Security $security,
    ) {
        $this->cartSessionStorage = $cartStorage;
        $this->cartFactory = $orderFactory;
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    /**
     * Gets the current cart or create new one.
     * 
     * @return Order
     */
    public function getCurrentCart(): ?Order
    {
        $cart = $this->cartSessionStorage->getCart();

        if (!$cart instanceof Order) {
            $cart = null;
        }

        return $cart;
    }

    public function createNewCart(): Order
    {
        return $this->cartFactory->create(null);
    }

    /**
     * Persists the cart in database and session.
     *
     * @param Order $cart
     */
    public function save(Order $cart): void
    {
        // Persist in database
        $this->entityManager->persist($cart);
        $this->entityManager->flush();
        // Persist in session
        $this->cartSessionStorage->setCart($cart);
    }
}
