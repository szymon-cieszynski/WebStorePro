<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OrderRepository;

class UserController extends AbstractController
{
    #[Route('/orders', name: 'view_orders')]
    public function viewOrders(OrderRepository $productRepository): Response
    {


        return $this->render('user/orders.html.twig', [
            'orders' => $productRepository->findAll(),
        ]);
    }
}
