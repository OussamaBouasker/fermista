<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserType2;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/user')]
final class UserController extends AbstractController
{
    #[Route(name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository,Request $request, PaginatorInterface $paginator): Response
    {
        $query = $userRepository->createQueryBuilder('u')->getQuery();
        
        $users = $paginator->paginate(
            $query, // Requête à paginer
            $request->query->getInt('page', 1), // Numéro de la page, 1 par défaut
            5 // Nombre d'éléments par page
        );
    
        return $this->render('Back/user/index.html.twig', [
            'users' => $users,
        ]);}

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $mimeType = $imageFile->getMimeType();
                if (!in_array($mimeType, ['image/jpeg', 'image/png'])) {
                    $this->addFlash('error', 'Seules les images JPEG et PNG sont autorisées.');
                    return $this->redirectToRoute('app_register');
                }

                if ($imageFile->getSize() > 2 * 1024 * 1024) { // Limite de 2 Mo
                    $this->addFlash('error', 'L\'image ne doit pas dépasser 2 Mo.');
                    return $this->redirectToRoute('app_register');
                }

                $destination = $this->getParameter('kernel.project_dir') . '/public/uploads/images';
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                // Déplacer l'image
                $imageFile->move($destination, $newFilename);

                // Enregistrer le chemin de l'image dans l'entité User
                $user->setImage('uploads/images/' . $newFilename);
            }

            // Get password from form
            $plainPassword = $form->get('password')->getData();

            if (!empty($plainPassword)) {
                // Hash the password
                $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
                $user->setPassword($hashedPassword);
            }

            $selectedRole = $form->get('roles')->getData(); // Get the selected role
            $user->setRoles([$selectedRole]); // Store it as an array
    
            $entityManager->persist($user);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('Back/user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('Back/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(UserType2::class, $user);

        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Get the new password from the form
           
            $selectedRole = $form->get('roles')->getData(); // Get the selected role
            $user->setRoles([$selectedRole]); // Store it as an array
                    // Gestion de l'image
        /** @var UploadedFile $imageFile */
        $imageFile = $form->get('image')->getData();
        if ($imageFile) {
            $destination = $this->getParameter('kernel.project_dir') . '/public/uploads/images';
            $newFilename = uniqid() . '.' . $imageFile->guessExtension();

            // Déplacer l'image dans le dossier public/uploads/images
            $imageFile->move($destination, $newFilename);

            // Mettre à jour le chemin de l'image dans l'entité User
            $user->setImage('uploads/images/' . $newFilename);
        }

    
            $entityManager->flush();
    
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('Back/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }



 // src/Controller/UserController.php

 #[Route('/user/search', name: 'app_user_search', methods: ['GET'])]
 public function search(Request $request, UserRepository $userRepository): JsonResponse
 {
     $searchTerm = $request->query->get('searchTerm', '');
     $page = $request->query->get('page', 1); // Récupère le numéro de page
     $limit = 5; // Nombre d'éléments par page
     $offset = ($page - 1) * $limit; // Calcule l'offset
 
     // Récupère les utilisateurs paginés
     $users = $userRepository->searchAndFilter($searchTerm, $offset, $limit)->getResult();
 
     // Récupère le nombre total d'utilisateurs pour la pagination
     $totalUsers = $userRepository->countSearchResults($searchTerm);
 
     // Transforme les résultats en un tableau simple pour JSON
     $data = [];
     foreach ($users as $user) {
         $data[] = [
             'id' => $user->getId(),
             'firstName' => $user->getFirstName(),
             'lastName' => $user->getLastName(),
             'email' => $user->getEmail(),
             'roles' => $user->getRoles(),
             'image' => $user->getImage(),
             'number' => $user->getNumber(),
         ];
     }
 
     // Renvoie les données avec des informations de pagination
     return $this->json([
         'users' => $data,
         'total' => $totalUsers,
         'page' => $page,
         'limit' => $limit,
     ]);
 }
}
