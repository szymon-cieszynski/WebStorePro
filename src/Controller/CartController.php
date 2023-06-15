<?php

namespace App\Controller;

use App\Entity\ShippingDetails;
use App\Form\CartType;
use App\Entity\ShippingType;
use App\Form\ShippingDetailsType;
use App\Manager\CartManager;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart')]
    public function index(CartManager $cartManager, Request $request): Response
    {
        $cart = $cartManager->getCurrentCart();

        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);

        // $sessionId = '3hi6qmj5sgdur9vbi6319gjft2';
        // $cartId = $_SESSION[$sessionId]['cartId'];
        // dd($cartId);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!$cart->isEmpty()) {
                $cart->setUpdatedAt(new \DateTime());
                $cartManager->save($cart);
            }
            // $cart->setUpdatedAt(new \DateTime());
            // $cartManager->save($cart);
            return $this->redirectToRoute('cart');
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'form' => $form->createView()
        ]);
    }

    #[Route('/checkout', name: 'checkout')]
    public function checkout(CartManager $cartManager, Request $request): Response
    {
        $shippingDetails = new ShippingDetails();
        $form = $this->createForm(ShippingDetailsType::class, $shippingDetails);
        $form->handleRequest($request);

        $cart = $cartManager->getCurrentCart();

        if ($form->isSubmitted() && $form->isValid()) {
            $cart->setUpdatedAt(new \DateTime());
            $cart->setShippingDetails($shippingDetails);
            $cart->setStatus('done');

            $entityManager = $this->getDoctrine()->getManager();
            $shippingTypeId = $form->get('shippingType')->getData();
            $shippingType = $entityManager->getRepository(ShippingType::class)->find($shippingTypeId);

            if ($shippingType) {
                $total = $cart->getTotal() + $shippingType->getPrice();
                $cart->setTotal($total);
            }


            //$entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($shippingDetails);
            $entityManager->persist($cart);
            $entityManager->flush();

            return $this->render('cart/success.html.twig');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $shippingTypes = $entityManager->getRepository(ShippingType::class)->findAll();
        $shippingTypesData = [];

        foreach ($shippingTypes as $shippingType) {
            $shippingTypesData[] = [
                'id' => $shippingType->getId(),
                'price' => $shippingType->getPrice(),
            ];
        }
        //dd($shippingTypesData);

        return $this->render('cart/checkout.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart,
            'shippingTypes' => $shippingTypesData,
        ]);
    }

    // #[Route('/proceed-order/{orderId}', name: 'proceed_order')]
    // public function proceedToOrder(OrderRepository $orderRepository, string $orderId): Response
    // {
    //     $order = $orderRepository->find($orderId);

    //     if (!$order || $order->getStatus() !== 'cart') {
    //         throw $this->createNotFoundException('Invalid order or order not in cart state');
    //     }

    //     return $this->redirectToRoute('cart');
    // }
}
