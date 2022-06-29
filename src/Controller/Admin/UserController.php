<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

#[Route('/admin/users', name: 'admin_users_')]
class UserController extends AbstractController{

    #[Route('/', name: 'index')]
    public function index(UserRepository $userRepository): Response {

        $users = $userRepository->findAll();
        return $this->render('admin/users/index.html.twig', compact('users'));

    }

    #[Route('/add', name: 'add')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }
        return $this->render('admin/users/manage/add.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function editUser(UserRepository $userRepository): Response {

        $users = $userRepository->findAll();
        return $this->render('admin/users/manage/edit.html.twig', compact('users'));

    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deleteUser(UserRepository $userRepository): Response {

        $users = $userRepository->findAll();
        return $this->render('admin/users/index.html.twig', compact('users'));

    }
}
