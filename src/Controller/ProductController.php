<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/product', name: 'app_product_')]
 class ProductController extends AbstractController
{
     //root avec Methode 
    #[Route('s', name: 'app_product')]
    public function index(ProductRepository $productRepository): Response
    {
        $product =$productRepository->findAll();
        return $this->render('product/index.html.twig', [
            'products_list' => $product,]
        );
    }
    // src/Controller/ProductController.php


    #[Route('/new', name: 'app_product_new')]
    public function newProducts(): Response
    {
        return new Response('<h1>Voici nos derniers produits !</h1>');
    }    

     //root avec Methode 
    #[Route('/{id<\d+>}', name: 'app_product_show')]
    public function show(int $id,ProductRepository $productRepository): Response
    {
        // On simule la récupération de la base de données
        $product = $productRepository->find($id);
        
        

        if (!$product) {
            throw $this->createNotFoundException('Le produit demandé n\'existe pas !');
        }

        return $this->render('product/show.html.twig', [
            'product_item' => $product,
        ]);
    }

}
