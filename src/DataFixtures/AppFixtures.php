<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\ProductImage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    private const string IMAGE_FOLDER_PATH = 'assets/media/product/';
    private const string PUBLIC_IMAGE_FOLDER_PATH = 'media/product/';

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('en_US');
    }

    public function load(ObjectManager $manager): void
    {
         $productImagesFiles = $this->getProductImages();

         for ($i = 0; $i < count($productImagesFiles); $i++) {
             $productImage = (new ProductImage())
                 ->setPath(self::PUBLIC_IMAGE_FOLDER_PATH . $productImagesFiles[$i]);

             $product = (new Product())
                 ->setName($this->faker->name())
                 ->setSku($this->faker->ean13())
                 ->setActive(true)
                 ->setDescription($this->faker->text())
                 ->setShippingDelay($this->faker->numberBetween(1, 3))
                 ->addImage($productImage);

             $manager->persist($product);
             $manager->persist($productImage);
         }

        $manager->flush();
    }

    private function getProductImages(): array
    {
        return array_values(array_diff(scandir(self::IMAGE_FOLDER_PATH), ['.', '..']));
    }
}
