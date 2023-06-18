<?php

use App\Entity\Order;
use App\Entity\OrderItem;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testGetCreatedAt()
    {
        $order = new Order();
        $createdAt = new \DateTime();
        $order->setCreatedAt($createdAt);

        $actualDateTime = $order->getCreatedAt();

        $this->assertSame($createdAt, $actualDateTime);
    }

    public function testIsEmpty()
    {
        $order = new Order();
        $this->assertTrue($order->isEmpty());

        $item = new OrderItem();
        $order->addItem($item);

        //Check if the order is not empty, indicating that the shopping basket is filled
        $this->assertFalse($order->isEmpty());
    }

    public function testAddItem()
    {
        $order = new Order();
        $item = new OrderItem();
        $order->addItem($item);

        // Check if the order is not empty
        $this->assertFalse($order->isEmpty());

        // Check if the added item is in the order
        $this->assertTrue($order->getItems()->contains($item));
    }
}
