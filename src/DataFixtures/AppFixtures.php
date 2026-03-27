<?php
namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $cat1 = new Category();
        $cat1->setName('Électronique');
        $cat1->setDescription('Casques, enceintes, gadgets');
        $manager->persist($cat1);

        $cat2 = new Category();
        $cat2->setName('Mode');
        $cat2->setDescription('Vêtements et accessoires');
        $manager->persist($cat2);

        $cat3 = new Category();
        $cat3->setName('Sports');
        $cat3->setDescription('Équipements de sport');
        $manager->persist($cat3);

        $p1 = new Product();
        $p1->setName('Casque Sans-Fil');
        $p1->setPrice('79.99');
        $p1->setStock(15);
        $p1->setDescription('Casque Bluetooth premium avec réduction de bruit.');
        $p1->setCategory($cat1);
        $manager->persist($p1);

        $p2 = new Product();
        $p2->setName('Enceinte Bluetooth');
        $p2->setPrice('59.99');
        $p2->setStock(20);
        $p2->setDescription('Enceinte portable waterproof.');
        $p2->setCategory($cat1);
        $manager->persist($p2);

        $p3 = new Product();
        $p3->setName('Veste en Cuir');
        $p3->setPrice('149.99');
        $p3->setStock(8);
        $p3->setDescription('Veste en cuir véritable, coupe classique.');
        $p3->setCategory($cat2);
        $manager->persist($p3);

        $p4 = new Product();
        $p4->setName('Tapis de Yoga');
        $p4->setPrice('29.99');
        $p4->setStock(35);
        $p4->setDescription('Tapis antidérapant extra-épais.');
        $p4->setCategory($cat3);
        $manager->persist($p4);

        $manager->flush();
    }
} 
