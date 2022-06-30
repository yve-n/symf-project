<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Process\Process;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/product', name: 'admin_product_')]
class ProductController extends AbstractController
{

    public function __construct(private SluggerInterface $slugger){}
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
    public function addProduct(Request $request , EntityManagerInterface $entityManager){

        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setSlug($this->slugger->slug($product->getName())->lower());
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('admin_product_index');
        }
        return $this->render('admin/product/manage/add.html.twig', [
            'addForm' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function editProduct(Request $request , ProductRepository $productRepository,EntityManagerInterface $entityManager ){
        $product = $productRepository->findOneBy(['id' => $request->get('id')]);
        
        if($product){
            $formEdit = $this->createForm(ProductType::class, $product);
            $formEdit->handleRequest($request);   
            if($formEdit->isSubmitted() && $formEdit->isValid()){
                $product->setSlug($this->slugger->slug($product->getName())->lower());
                $entityManager->persist($formEdit->getData());
                $entityManager->flush();
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
        if($product){
            $em = $doctrine->getManager();
            $productRepository->remove($product);
            $em->flush();
            return $this->redirectToRoute('admin_product_index');
        }
    }


}
