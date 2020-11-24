<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class GeneralController extends AbstractController
{
    /**
     * @Route("/", name="general")
     */
    public function index(): Response
    {
        return $this->render('general/index.html.twig', [
            'controller_name' => 'GeneralController',
        ]);
    }

    /**
     * @Route("/catalogue", name="cata", methods={"GET"})
     */
    public function cata(ProductRepository $productRepository): Response
    {
        return $this->render('general/catalogue.html.twig', [
            'products' => $productRepository->findAll(),
        ]);

        
    }
    /**
     * @Route("/{id}/show", name="_showcata" , methods={"GET"})
     */
    public function showcata(Product $product) :Response
    {
        return $this->render('general/showcata.html.twig', [
          
            'product' => $product,
        ]);

    }



  /**
     * @Route("/the", name="the", methods={"GET"})
     */
    public function the(ProductRepository $productRepository): Response
    {
        return $this->render('general/the.html.twig', [
            'products' => $productRepository->findAll(),
        ]);

        
    }

 /**
     * @Route("/cafe", name="cafe", methods={"GET"})
     */
    public function cafe(ProductRepository $productRepository): Response
    {
        return $this->render('general/cafe.html.twig', [
            'products' => $productRepository->findAll(),
        ]);

        
    }

     /**
     * @Route("/boissonalternative", name="drinkalt", methods={"GET"})
     */
    public function boissonalt(ProductRepository $productRepository): Response
    {
        return $this->render('general/drinkalt.html.twig', [
            'products' => $productRepository->findAll(),
        ]);

        
    }



}
