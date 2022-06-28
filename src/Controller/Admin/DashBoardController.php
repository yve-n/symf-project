<?php

namespace App\Controller\Admin;

use App\Repository\CategoryRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashBoardController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(CategoryRepository $categoryRepository, 
    ProductRepository $productRepository, 
    UserRepository $userRepository,
    OrderRepository $orderRepository): Response
    {
        $categoryCount = $categoryRepository->count([]);
        $productCount = $productRepository->count([]);
        $orderCount = $orderRepository->count([]);
        $userCount = $userRepository->count([]);
        return $this->render('admin/dashboard/index.html.twig', compact(
            'categoryCount',
            'productCount',
            'orderCount',
            'userCount'
            )   
        );
    }
}
