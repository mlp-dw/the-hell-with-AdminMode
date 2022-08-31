<?php

namespace App\Controller;

use App\Entity\Quizz;
use App\Entity\User;
use App\Form\AddUserAdminForm;
use App\Form\UserType;
use App\Repository\QuizzRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mon-compte')]
class UserController extends AbstractController
{

    #[Route('/profil', name: 'app_profile', methods: ['GET', 'POST'])]
    public function profile(): Response
    {
        // usually you'll want to make sure the user is authenticated first,
        // see "Authorization" below
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        
        // Call whatever methods you've added to your User class
        // For example, if you added a getFirstName() method, you can use that.
        // return new Response('Well hi there '. $user->getEmail());

        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/mes-modeles', name: 'app_modeles', methods: ['GET', 'POST'])]
    public function show(): Response
    {
        $user = $this->getUser();
        $quizzs = $user->getQuizzs();
        
        return $this->renderForm('user/modeles.html.twig', [
            'user' => $user,
            'quizzs' => $quizzs,
        ]);
    }

    #[Route('/modifier-profil', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
            $userRepository->add($user, true);
            $this->addFlash('success', 'Votre profil a bien été modifié');
            return $this->redirectToRoute('app_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    ///// ADMIN
    #[Route('/admin-index', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    // #[Route('/ajouter-utilisateur', name: 'app_user_new', methods: ['GET', 'POST'])]
    // // #[ParamConverter('user', class: 'User')]
    // public function new(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    // {
    //     $user = new User();
    //     $form = $this->createForm(AddUserAdminForm::class, $user);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         // encode the plain password
    //         $user->setPassword(
    //         $userPasswordHasher->hashPassword(
    //                 $user,
    //                 $form->get('plainPassword')->getData()
    //             )
    //         );

    //         $entityManager->persist($user);
    //         $entityManager->flush();


    //         return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('user/new.html.twig', [
    //         'form' => $form->createView(),
    //     ]);
    

    //     // if ($form->isSubmitted() && $form->isValid()) {
    //     //     $userRepository->add($user, true);

    //     //     return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    //     // }

    //     // return $this->renderForm('user/new.html.twig', [
    //     //     'user' => $user,
    //     //     'form' => $form,
    //     // ]);
    // }
    #[Route('/profil/{id}', name: 'app_profile_users', methods: ['GET', 'POST'])]
    public function profileAdmin(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $id = $request->request->get("id");
        $user = $userRepository->findOneBy(['id' => $id]);
        dd($id, $user);
        $quizzs = $user->getQuizzs();
        
        return $this->renderForm('user/modeles.html.twig', [
            'user' => $user,
            'quizzs' => $quizzs,
        ]);
    }
    #[Route('/modifier-profil/{id}', name: 'app_profile_edit', methods: ['GET', 'POST'])]
    public function editProfileAdmin(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $id = $request->request->get('id');
        $user = $userRepository->findOneBy(['id' => $id]);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
            $userRepository->add($user, true);
            $this->addFlash('success', 'Le profil a bien été modifié');
            return $this->redirectToRoute('app_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
