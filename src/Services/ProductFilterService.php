<?php

namespace App\Services;

use App\Repository\ProductRepository;

readonly class ProductFilterService
{
    public function __construct(
        private ProductRepository $productRepository
    )
    {
    }

    public function getProducts(array $filters): array
    {
        return $this->productRepository->getProductsByFilters($filters);
    }
}
