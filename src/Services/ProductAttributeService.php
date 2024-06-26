<?php

namespace App\Services;

use App\Entity\ProductAttribute;

class ProductAttributeService
{
    public function getAttributes(array $products): array
    {
        $attributes = [];

        foreach ($products as $product) {
            /** @var ProductAttribute $attribute */
            foreach ($product->getAttributes() as $attribute) {
                $attributes[$attribute->getName()][] = $attribute->getValue();
            }
        }

        return array_map('array_unique', $attributes);
    }
}
