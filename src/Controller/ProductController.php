<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ProductType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface; // N'oubliez pas l'import
use Symfony\Component\HttpFoundation\Request;
#[Route('/product', name: '')]
 class ProductController extends AbstractController
{

    #[Route('', name: 'app_product')]
    public function index(ProductRepository $productRepository): Response
    {
        $product =$productRepository->findAll();
        return $this->render('product/index.html.twig', [
            'products_list' => $product,]
        );
    }
    // src/Controller/ProductController.php


    #[Route('/new', name: 'app_product_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        
       
        $form = $this->createForm(ProductType::class, $product);

        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($product); 
            $entityManager->flush();  
              
            //redirection
            return $this->redirectToRoute('app_product');
        }

        //si il ne clik pas afficher cette page new.htm.twig        
        return $this->render('product/new.html.twig', [
            'productForm' => $form->createView(),
        ]);
    } 
    
    #[Route('/edit/{id}',name:'app_product_edit')]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager ):Response
    {
        $form = $this -> createForm(ProductType::class ,$product);
        $form->handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()){
            $entityManager ->flush();
            return $this ->redirectToRoute('app_product');
        }

        return $this->render('product/edit.html.twig',[
            'productForm'=> $form->createView(),
            'product_view' => $product,
        ]);
    } 

    // src/Controller/ProductController.php

#[Route('/product/delete/{id}', name: 'app_product_delete', methods: ['POST'])]
public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
{
    // 1. Récupération du jeton CSRF soumis par le formulaire
    $submittedToken = $request->request->get('_token');

    // 2. Vérification du jeton (ID du jeton et valeur soumise)
    if ($this->isCsrfTokenValid('delete' . $product->getId(), $submittedToken)) {
        
        // 3. Suppression (via Doctrine)
        $entityManager->remove($product); // Prépare la suppression
        $entityManager->flush();           // Exécute la requête SQL (DELETE)
    }

    // Redirection vers la liste
    return $this->redirectToRoute('app_products_index');
}

}
