<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashBoardController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(CategoryRepository $categoryRepository, 
    ProductRepository $productRepository, 
    UserRepository $userRepository,
    OrderRepository $orderRepository): Response
    {
        $limit = 6;
        $users = $userRepository->getLastUsers(4);
        $categories = $categoryRepository->getLastCategories(4);
        $categoryCount = $categoryRepository->count([]);
        $productCount = $productRepository->count([]);
        $orderCount = $orderRepository->count([]);
        $userCount = $userRepository->count([]);
        $lastProduct = $productRepository->getLastProducts($limit);
        return $this->render('admin/dashboard/index.html.twig', compact(
            'categoryCount',
            'productCount',
            'orderCount',
            'userCount',
            'lastProduct',
            'categories',
            'users'
            )   
        );
    }
    // #[Route('/admin/edit/{id}', name: 'admin_dashboard')]
    // public function edit(Request $request , ProductRepository $productRepository, ManagerRegistry $doctrine){
    //     $product = $productRepository->findOneBy(['id' => $request->get('id')]);
        
    //     if($product){
    //         $formEdit = $this->createForm(ProductType::class, $product);
    //         $formEdit->handleRequest($request);   
    //         if($formEdit->isSubmitted() && $formEdit->isValid()){
    //             $em = $doctrine->getManager();
    //             $em->persist($formEdit->getData());
    //             $em->flush();
    //             return $this->redirectToRoute('');
    //         } 
    //     }else{
    //         return $this->redirectToRoute('');
    //     }

    //     return $this->render('admin/dashboard/index.html.twig',[
    //         'formEdit' => $formEdit->createView()
    //     ]);

    // }

}
