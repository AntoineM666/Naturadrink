<?php

namespace App\service\cart;


use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cartservice{

    protected $session;
    protected $ProductRepository;
    public function __construct(SessionInterface $session,ProductRepository $ProductRepository)
    {
        $this->session = $session;
        $this->ProductRepository = $ProductRepository;

    }



    public function add(int $id){
        $panier = $this->session->get('panier',[]);

        if(!empty($panier[$id])){
            $panier[$id]++;
        }
        else{
              $panier[$id] = 1;
        }

      
        
        $this->session->set('panier',$panier);
    }

    public function remove(int $id){

        $panier = $this->session->get('panier', []);

        if(!empty($panier[$id]))
        {
            unset($panier[$id]);
        }

        $this->session->set('panier',$panier); 
    }

    public function getFullcart() : array{

            $panier = $this->session->get('panier',[]);
            $panierWithData=[];
            foreach($panier as $id => $quantity)
            {
            $panierWithData[]=[
                'product'=> $this->ProductRepository->find($id),
                'quantity'=> $quantity
            ];
    
        }
        return $panierWithData;
    }


     public function getTotal() 
     {
        $total = 0 ;
        
        foreach( $this->getFullcart() as $item ){
            
            $total += $item['product']->getPrice() * $item['quantity'];

            
        }
        return $total;
     }
}