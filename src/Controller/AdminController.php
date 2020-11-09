<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }


    /**
     * liste des utilisateurs
     * 
     * @IsGranted("ROLE_ADMIN")
     * @route("/utilisateur" , name="utilisateur")
     */
    public function userlist(UserRepository $users)
    { 
        return $this->render("admin/list_user.html.twig",[
            'user'=>$users->findAll()
        ]
        );
    }

    /**
     * assignation de roles pour un utilisateur
     * 
     * @IsGranted("ROLE_ADMIN")
     * @Route ("/utilisateur/modifier/{id}" ,name="edit_user")
     */
    public function editUser(User $user , Request $request){
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message','utilisateur modifié avec succés');
            return $this->redirectToRoute('admin');

        }
        return $this->render('admin/edituser.html.twig',
        [
            'userForm' => $form->createView()
        ]);
    }
}
