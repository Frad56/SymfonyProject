<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');
        $categorieNames = ['Informatique', 'Maison', 'Sport', 'Mode', 'Beauté'];
        $categories=[];
        
        foreach ($categorieNames as $name) {
            $cat = new Categorie();
            $cat->setName($name);
            $manager->persist($cat);
            $categories[] = $cat; 
        }
        for($i = 0; $i < 10 ; $i++){

            $product = new Product();
          
            $product->setName('Product' . $i );

            $description= $faker->sentence();
            $description = substr($description,0,25);
            $product -> setDescription($description);

            $product -> setPrice(mt_rand(10,100));


            $randKey = array_rand($categories);
            $product->setCategorie($categories[$randKey]);


            $product -> setImage("Images/produit{$i}.jpg");

        


           // $product -> setCategorie('Catehorie Par ID' . $i);
             $manager->persist($product);

        }
        

        $manager->flush();
    }
}
