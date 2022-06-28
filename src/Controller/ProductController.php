<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/products', name: 'app_products_')]
class ProductController extends AbstractController
{

    public function __construct(private ProductRepository $productRepository){}
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/{slug}', name: 'details')]
    public function details( Product $product): Response
    {
        $relatedProducts = $this->productRepository->findProductsOfcategory($product->getCategory(), $product->getId());
       
        // dd($relatedProducts);
        return $this->render('product/details.html.twig', compact('product', 'relatedProducts'));
            
    }
}
