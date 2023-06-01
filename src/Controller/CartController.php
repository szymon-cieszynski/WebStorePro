<?php

namespace App\Controller;

use App\Form\CartType;
use App\Form\ShippingDetailsType;
use App\Manager\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $form = $this->createForm(ShippingDetailsType::class);
        $form->handleRequest($request);

        return $this->render('cart/checkout.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
