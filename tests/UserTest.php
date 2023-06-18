<?php

namespace App\Tests;

use App\Entity\Order;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetEmail(): void
    {
        $user = new User();
        $user->setEmail('sklep@example.com');

        $email = $user->getEmail();

        $this->assertEquals('sklep@example.com', $email);
    }

    public function testAddOrder(): void
    {
        $user = new User();
        $order = new Order();

        $user->addOrder($order);

        //check if collection of orders and user contains exact 1 element
        $this->assertCount(1, $user->getOrders());
        //check if user is the same user assigned to order
        $this->assertSame($user, $order->getUser());

        //check if duplicates are ignored
        $user->addOrder($order);
        $this->assertCount(1, $user->getOrders());

        //check if objects are detached correctly
        $user->removeOrder($order);
        $this->assertCount(0, $user->getOrders()); //if collection will conatin object, removeOrder didn't works properly
        $this->assertNull($order->getUser());
    }

    public function testRemoveOrder(): void
    {
        $user = new User();
        $order = new Order();

        $user->removeOrder($order);

        //check if collection of orders is empty
        $this->assertCount(0, $user->getOrders());

        $this->assertNull($order->getUser());
    }
}
