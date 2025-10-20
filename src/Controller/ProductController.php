<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/product', name: 'app_product_')]
 class ProductController extends AbstractController
{
    #[Route('s', name: 'app_product')]
    public function index(): Response
    {
        $product = [
            ['id' => 0, 'name' => 'Ordinateur Portable', 'price' => 1200, 'description' => 'Un PC puissant.', 'image' => 'images/laptop.png'],
            ['id' => 1, 'name' => 'Clavier Mécanique', 'price' => 150, 'description' => 'Frappe précise.', 'image' => 'images/keyboard.png'],
            ['id' => 2, 'name' => 'Souris Gamer', 'price' => 80, 'description' => 'Haute précision.', 'image' => 'images/mouse.png'],
            ['id' => 3, 'name' => 'Écran 4K', 'price' => 750, 'description' => 'Image nette.', 'image' => 'images/monitor.png']
        ];
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
#[Route('/{id<\d+>}', name: 'app_product_show')]
public function show(int $id): Response
{
    // On simule la récupération de la base de données
    $products = [
        ['id' => 0, 'name' => 'Ordinateur Portable', 'price' => 1200, 'description' => 'Un PC puissant.', 'image' => 'images/laptop.png'],
        ['id' => 1, 'name' => 'Clavier Mécanique', 'price' => 150, 'description' => 'Frappe précise.', 'image' => 'images/keyboard.png'],
        // ... etc
    ];
    
    $foundProduct = null;
    foreach ($products as $product) {
        if ($product['id'] === $id) {
            $foundProduct = $product;
            break;
        }
    }

    if (!$foundProduct) {
        throw $this->createNotFoundException('Le produit demandé n\'existe pas !');
    }

    return $this->render('product/show.html.twig', [
        'product_item' => $foundProduct,
    ]);
}

}
