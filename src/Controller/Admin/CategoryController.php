<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/category', name: 'admin_category_')]
class CategoryController extends AbstractController
{
    public function __construct(private SluggerInterface $slugger){}
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
    public function addCategory(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           $category->setSlug($this->slugger->slug($category->getName())->lower());
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('admin_category_index');
        }
        return $this->render('admin/category/manage/add.html.twig', [
            'addForm' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function editCategory(CategoryRepository $categoryRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = $categoryRepository->findOneBy(['id' => $request->get('id')]);
        if($category){
            $formEdit = $this->createForm(CategoryType::class, $category);
            $formEdit->handleRequest($request);
            if($formEdit->isSubmitted() && $formEdit->isValid())
            {
                $category->setSlug($this->slugger->slug($category->getName())->lower());
                $categoryRepository->add($category);
                $entityManager->flush();
                return $this->redirectToRoute('admin_category_index');
            }
        }else{
            return $this->redirectToRoute('admin_dashboard');  
        }

        return $this->render('admin/category/manage/edit.html.twig', [
            'editCategory' => $formEdit->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deleteCategory(CategoryRepository $categoryRepository, Request $request, ManagerRegistry $doctrine): Response
    {
        $category = $categoryRepository->findOneBy(['id' => $request->get('id')]);
        if($category){
            $em = $doctrine->getManager();
            $categoryRepository->remove($category);
            $em->flush();
            return $this->redirectToRoute('admin_category_index');
        }
    }


}
