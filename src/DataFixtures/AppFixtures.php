<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\ProductAttribute;
use App\Entity\ProductImage;
use App\Enum\ProductAttribute\Difficulty;
use App\Enum\ProductAttribute\Flavor;
use App\Enum\ProductAttribute\Name;
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

             $attributeNames = Name::cases();

             for ($j = 0; $j < count($attributeNames); $j++) {
                $product->addAttribute($this->createAttribute($attributeNames[$j]->value, $manager));
             }

             $manager->persist($product);
             $manager->persist($productImage);
         }

        $manager->flush();
    }

    private function getProductImages(): array
    {
        return array_values(array_diff(scandir(self::IMAGE_FOLDER_PATH), ['.', '..']));
    }

    private function createAttribute(string $attribute, ObjectManager $manager): ProductAttribute
    {
        $value = null;
        $type = null;

        if (in_array($attribute, [Name::FLAVOR->value, Name::FILLING->value, Name::FROSTING->value])) {
            $value = $this->getEnumValues(Flavor::cases());
            $type = 'string';
        } elseif ($attribute === Name::HAS_SPRINKLES->value || $attribute === Name::IS_VEGAN->value) {
            $value = $this->faker->boolean();
            $type = 'boolean';
        } elseif ($attribute === Name::DIFFICULTY->value) {
            $value = $this->getEnumValues(Difficulty::cases());
            $type = 'string';
        }

        $attribute = (new ProductAttribute())
            ->setName($attribute)
            ->setType($type)
            ->setValue($value);

        $manager->persist($attribute);

        return $attribute;
    }

    private function getEnumValues(array $enums): string
    {
        return $this->faker->randomElement($enums)->value;
    }
}
