<?php

namespace App\Controller\Admin;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/category', name: 'admin_category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('admin/category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'categories' => $categories,
        ]);
    }

    #[Route('/add', name: 'add')]
    public function addCategory(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('admin/category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'categories' => $categories,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function editCategory(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('admin/category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'categories' => $categories,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deleteCategory(CategoryRepository $categoryRepository): Response
    {
        return $this->redirectToRoute('admin_category_index');
    }


}
