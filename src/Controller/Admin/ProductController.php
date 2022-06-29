<?php

namespace App\Controller\Admin;

use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/product', name: 'admin_product_')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('admin/product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products,
        ]);
    }

    #[Route('/add', name: 'add')]
    public function addProduct(Request $request , ProductRepository $productRepository, ManagerRegistry $doctrine){

        return $this->render('admin/product/manage/edit.html.twig',[
            'formAdd' => ""
        ]);

    }

    #[Route('/edit/{id}', name: 'edit')]
    public function editProduct(Request $request , ProductRepository $productRepository, ManagerRegistry $doctrine){
        $product = $productRepository->findOneBy(['id' => $request->get('id')]);
        
        if($product){
            $formEdit = $this->createForm(ProductType::class, $product);
            $formEdit->handleRequest($request);   
            if($formEdit->isSubmitted() && $formEdit->isValid()){
                $em = $doctrine->getManager();
                $em->persist($formEdit->getData());
                $em->flush();
                return $this->redirectToRoute('admin_product_index');
            } 
        }else{
            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/product/manage/edit.html.twig',[
            'formEdit' => $formEdit->createView()
        ]);

    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deleteProduct(Request $request , ProductRepository $productRepository, ManagerRegistry $doctrine){

        $product = $productRepository->findOneBy(['id' => $request->get('id')]);
        return $this->redirectToRoute('admin_product_index');
         
    }


}
