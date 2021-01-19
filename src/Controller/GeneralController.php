<?php

namespace App\Controller;


use Stripe\Stripe;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
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

    /**
    * @Route("{id}/create-checkout-session", name="checkout")
    */
    public function checkout(Product $product)
    {
        \Stripe\Stripe::setApiKey('sk_test_51HtZJ1H9uCMtPurA36KmUuJJJPfasqruJr6Hz6L7JURruYCGBsnZpJ7ONrf67ZoJRsSR0ZSjAtgs7vLb8QJLLKXU00zHUcvVAJ');

        
        
            $session = \Stripe\Checkout\Session::create([
            
            'payment_method_types' => ['card'],
            'line_items' => [[
              'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                  'name' => $product->getTitle(),
                  
                ],
                'unit_amount' => $product->getPrice()*100,
              ],
              'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('success',[],UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('error',[],UrlGeneratorInterface::ABSOLUTE_URL),

          ]);

              return new JsonResponse( [ 'id' => $session->id ] );

    }

    /**
     * @Route("/success" , name="success")
     */
    public function success()
    {
        return $this->render('general/success.html.twig');
    }

    /**
     * @Route("/error", name="error")
     */
    public function error()
    {
        return $this->render('general/error.html.twig');
    }



}
