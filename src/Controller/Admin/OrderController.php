<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route('/add', name: 'add')]
    public function addProduct(Request $request , EntityManagerInterface $entityManager){

        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($order);
            $entityManager->flush();

            return $this->redirectToRoute('admin_orders_index');
        }
        return $this->render('admin/order/manage/add.html.twig', [
            'addForm' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function editProduct(Request $request , OrderRepository $orderRepository,EntityManagerInterface $entityManager ){
        $order = $orderRepository->findOneBy(['id' => $request->get('id')]);
        
        if($order){
            $formEdit = $this->createForm(OrderType::class, $order);
            $formEdit->handleRequest($request);   
            if($formEdit->isSubmitted() && $formEdit->isValid()){
                $entityManager->persist($formEdit->getData());
                $entityManager->flush();
                return $this->redirectToRoute('admin_orders_index');
            } 
        }else{
            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/order/manage/edit.html.twig',[
            'formEdit' => $formEdit->createView()
        ]);

    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deleteProduct(Request $request , OrderRepository $orderRepository, ManagerRegistry $doctrine){

        $order = $orderRepository->findOneBy(['id' => $request->get('id')]);
        if($order){
            $em = $doctrine->getManager();
            $orderRepository->remove($order);
            $em->flush();
            return $this->redirectToRoute('admin_orders_index');
        }
    }
}
