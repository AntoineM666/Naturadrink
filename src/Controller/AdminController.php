<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Form\SearchFormType;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
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
            return $this->redirectToRoute('utilisateur');

        }
        return $this->render('admin/edituser.html.twig',
        [
            'userForm' => $form->createView(),
            'users'=> $user
        ]);
    }


     /**
     * liste du stock
     * 
     * @IsGranted("ROLE_ADMIN")
     * @route("/stock" , name="stock")
     */
    public function stock(ProductRepository $productRepository)
    { 
        return $this->render("admin/stock.html.twig",[
            'products'=>$productRepository->findAll()
        ]
        );
    }


    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}", name="deleteuser", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('utilisateur');
    }



    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/recherche", name="search")
     */
    public function recherche(Request $request, UserRepository $repo ) {
      
        $searchForm = $this->createForm(SearchFormType::class);
        $searchForm->handleRequest($request);
        
        $donnees = $repo;
 
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
 
            $email = $searchForm->getData()->getEmail();

            $donnees = $repo->search($email);


            if ($donnees == null) {
                $this->addFlash('erreur', 'Aucun article contenant ce mot clé dans le titre n\'a été trouvé, essayez en un autre.');
           
            }

    }

     

        return $this->render('admin/search.html.twig',[
            'user'=>$donnees ,
            'searchForm' => $searchForm->createView()
        ]);
    }





}
