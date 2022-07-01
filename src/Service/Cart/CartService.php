<?php 

namespace App\Service\Cart;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {

   
    
    // public function __construct( SessionInterface $session, ProductRepository $productRepository){
    //     $this->session = $session;
    //     $this->productRepository = $productRepository;
    // }

    // public function addToCart($id)
    // {
    //     $cart = $this->session->get('cart', []);

    //     if(!empty($cart[$id])){
    //         $cart[$id]++;
    //     }else{
    //         $cart[$id] = 1;
    //     }
    //     $this->session->set('cart', $cart);
    // }

    // public function removeFromCart($id)
    // {
    //     $cart = $this->session->get('cart', []);

    //     if(!empty($cart[$id])){
    //         if( $cart[$id] > 1){
    //             $cart[$id]--;
    //         }
    //     }else{       
    //         unset($cart[$id]);
    //     }
    //     $this->session->set('cart', $cart);
    // }

    // public function getFullCart() :array {

    //     $cart = $this->session->get('cart', []);
    //     $cartData = [];

    //     foreach ($cart as $id => $quantity) {
    //         $cartData[]=[
    //             'product' => $this->productRepository->find($id),
    //             'quantity' => $quantity
    //         ];
    //     }
    //     return $cartData;
    // }

    // public function getTotal() :float {
    //     $cartData = $this->getFullCart();
    //     $total = 0;
    //     foreach ($cartData as $cartItem) {
    //         $totalItem = $cartItem['product']->getPrice() * $cartItem['quantity'];
    //         $total += $totalItem;
    //     }
    //     return $total;
    // }

    // public function deleteCart(){}
}