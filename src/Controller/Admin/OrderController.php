<?php

namespace App\Controller\Admin;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/order', name: 'admin_orders_')]
class OrderController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findAll();
        return $this->render('admin/order/index.html.twig', [
            'controller_name' => 'OrderController',
            'orders' => $orders
        ]);
    }
}
