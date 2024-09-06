<?php

namespace App\Storage;

use App\Entity\Order;
use App\Entity\User;
use App\Repository\OrderRepository;
use App\Factory\OrderFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class CartSessionStorage
{
    /**
     * The request stack.
     */
    private RequestStack $requestStack;

    /**
     * The cart repository.
     */
    private OrderRepository $cartRepository;

    /**
     * Security.
     */
    private Security $security;

    private OrderFactory $cartFactory;

    private EntityManager $entityManager;

    /**
     * @var string
     */
    const CART_KEY_NAME = 'cart_id';

    /**
     * CartSessionStorage constructor.
     *
     * @param RequestStack $requestStack
     * @param OrderRepository $cartRepository
     */
    public function __construct(
        RequestStack $requestStack,
        OrderRepository $cartRepository,
        Security $security,
        OrderFactory $orderFactory,
        EntityManagerInterface $entityManager
    ) {
        $this->requestStack = $requestStack;
        $this->cartRepository = $cartRepository;
        $this->security = $security;
        $this->cartFactory = $orderFactory;
        $this->entityManager = $entityManager;
    }

    /**
     * Gets the cart in session.
     *
     * @return Order|null
     */
    public function getCart(): ?Order
    {
        /**
         * @var User|UserInterface|null $user
         */
        $user = $this->security->getUser();

        //user not logged in
        if (!$user instanceof User) {
            $cart = $this->cartRepository->findOneBy([
                'id' => $this->getCartId(),
                'status' => Order::STATUS_CART
            ]);

            if (!$cart) {
                return null;
            }
            return $cart;
        }

        //User logged in, get cart from the session
        $cart = $this->cartRepository->findOneBy([
            'id' => $this->getCartId(),
            'status' => Order::STATUS_CART
        ]);

        if ($cart) {
            if ($cart->isEmpty()) {
                return null;
            } else {
                $cart->setUser($user);
                $this->entityManager->flush();
            }
        } else {
            return null;
        }

        return $cart;
    }

    /**
     * Sets the cart in session.
     *
     * @param Order $cart
     */
    public function setCart(Order $cart): void
    {
        $this->getSession()->set(self::CART_KEY_NAME, $cart->getId());
    }

    /**
     * Returns the cart id.
     *
     * @return int|null
     */
    private function getCartId(): ?int
    {
        return $this->getSession()->get(self::CART_KEY_NAME);
    }

    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }
}
