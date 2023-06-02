<?php

namespace App\Controller;

use App\Entity\ShippingDetails;
use App\Form\CartType;
use App\Entity\Order;
use App\Form\ShippingDetailsType;
use App\Manager\CartManager;
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

        if ($form->isSubmitted() && $form->isValid()) {
            $cart->setUpdatedAt(new \DateTime());
            $cartManager->save($cart);

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
            $entityManager->persist($shippingDetails);
            $entityManager->persist($cart);
            $entityManager->flush();

            return $this->render('cart/success.html.twig');
        }

        return $this->render('cart/checkout.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart,
        ]);
    }
}
