<?php

namespace App\Factory;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class OrderFactory
 * @package App\Factory
 */
class OrderFactory
{
    /**
     * Creates an order.
     *
     * @return Order
     */
    public function create(?UserInterface $user = null): Order
    {
        $order = new Order();
        $order->setUser($user);
        $order
            ->setStatus(Order::STATUS_CART)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        return $order;
    }

    /**
     * Creates an item for a product.
     *
     * @param Product $product
     *
     * @return OrderItem
     */
    public function createItem(Product $product): OrderItem
    {
        $item = new OrderItem();
        $item->setProduct($product);
        $item->setQuantity(1);

        return $item;
    }
}
