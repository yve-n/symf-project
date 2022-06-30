<?php

namespace App\Controller\Admin;

use App\Entity\OrderDetail;
use App\Form\OrderDetailType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\OrderDetailRepository;
use App\Repository\OrderRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/order/detail', name: 'admin_order_detail_')]
class OrderDetailController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(OrderDetailRepository $orderDetailRepository): Response
    {
        $orderDetails = $orderDetailRepository->findAll();
        return $this->render('admin/order_detail/index.html.twig', compact('orderDetails'));
    }
    #[Route('/{id}', name: 'order')]
    public function getOrderDetails(Request $request, OrderDetailRepository $orderDetailRepository, OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->findOneBy(['id' => $request->get('id')]);
        $totalOrder = 0;
        if($order){
            $orderDetails = $order->getOrderDetails();
            foreach ($orderDetails as $od ) {
                $totalOrder += $od->getTotal();
            }
            // dd($totalOrder);
            return $this->render('admin/order_detail/details.html.twig', compact('orderDetails','totalOrder'));
        }
    }

    #[Route('/add', name: 'add')]
    public function addProduct(Request $request , EntityManagerInterface $entityManager){

        $orderDetail = new OrderDetail();
        $form = $this->createForm(OrderDetailType::class, $orderDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($orderDetail);
            $entityManager->flush();

            return $this->redirectToRoute('admin_order_detail_index');
        }
        return $this->render('admin/order_detail/manage/add.html.twig', [
            'addForm' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function editProduct(Request $request , OrderDetailRepository $orderDetailRepository,EntityManagerInterface $entityManager ){
        $orderDetail = $orderDetailRepository->findOneBy(['id' => $request->get('id')]);
        
        if($orderDetail){
            $formEdit = $this->createForm(OrderDetailType::class, $orderDetail);
            $formEdit->handleRequest($request);   
            if($formEdit->isSubmitted() && $formEdit->isValid()){
                $entityManager->persist($formEdit->getData());
                $entityManager->flush();
                return $this->redirectToRoute('admin_order_detail_index');
            } 
        }else{
            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/order_detail/manage/edit.html.twig',[
            'formEdit' => $formEdit->createView()
        ]);

    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deleteProduct(Request $request , OrderDetailRepository $orderDetailRepository, ManagerRegistry $doctrine){

        $orderDetail = $orderDetailRepository->findOneBy(['order_id' => $request->get('id')]);
        if($orderDetail){
            $em = $doctrine->getManager();
            $orderDetailRepository->remove($orderDetail);
            $em->flush();
            return $this->redirectToRoute('admin_order_detail_index');
        }
    }
}
