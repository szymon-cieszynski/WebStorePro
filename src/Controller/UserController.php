<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OrderRepository;
use Symfony\Component\Security\Core\Security;

class UserController extends AbstractController
{
    #[Route('/orders', name: 'view_orders')]
    public function viewOrders(OrderRepository $orderRepository, Security $security): Response
    {
        $user = $security->getUser();
        $userId = $user->getId();
        //dd($userId);

        return $this->render('user/orders.html.twig', [
            'orders' => $orderRepository->findAllOrdersById($userId),
        ]);
    }
}
