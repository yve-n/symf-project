<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/cart', name: 'app_cart_')]
class CartController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index( SessionInterface $session, ProductRepository $productRepository): Response
    {
        $cart = $session->get('cart', []);

        $cartData = [];

        foreach ($cart as $id => $quantity) {
            $cartData[]=[
                'product' => $productRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;
        foreach ($cartData as $cartItem) {
            $totalItem = $cartItem['product']->getPrice() * $cartItem['quantity'];
            $total += $totalItem;
        }
        // dd($cartData);

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'items' => $cartData,
            'total' => $total
        ]);
    }
    #[Route('/add/{id}', name: 'add')]
    public function addToCart($id, SessionInterface $session){
        $cart = $session->get('cart', []);

        if(!empty($cart[$id])){
            $cart[$id]++;
        }else{
            $cart[$id] = 1;
        }
        $session->set('cart', $cart);
        return $this->redirectToRoute('app_cart_index');
    }

    #[Route('/remove/{id}', name: 'remove')]
    public function removeFromCart($id, SessionInterface $session){
        $cart = $session->get('cart', []);

        if(!empty($cart[$id])){
            unset($cart[$id]);
        }
        $session->set('cart', $cart);
        return $this->redirectToRoute('app_cart_index');

    }
}
