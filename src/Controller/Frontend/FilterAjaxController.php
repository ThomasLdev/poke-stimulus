<?php

namespace App\Controller\Frontend;

use App\Services\ProductFilterService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/filter', name: 'app_filter')]
class FilterAjaxController extends AbstractController
{
    #[Route('/', name: '_render', methods: ['POST'])]
    public function index(ProductFilterService $productFilterService, Request $request): JsonResponse
    {
        $data = $this->getFormData($request);

        $productsTemplate = $this->renderView('product/include/items.html.twig', [
            'products' => $productFilterService->getProducts($data),
        ]);

        $filterHintsTemplate = $this->renderView('product/filters/_filter-hint.html.twig', [
            'hints' => $data,
        ]);

        return new JsonResponse(
            $this->formatResponse($productsTemplate, $filterHintsTemplate),
            Response::HTTP_OK
        );
    }

    #[Route('/', name: '_products_hints', methods: ['POST'])]
    public function hints(Request $request): JsonResponse
    {
        $template = $this->renderView('product/filters/_filter-hint.html.twig', [
            'hints' => json_decode($request->getContent(), true),
        ]);

        return new JsonResponse(['html' => $template], Response::HTTP_OK);
    }

    private function getFormData(Request $request): array
    {
        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException('Invalid JSON data');
        }

        return $data;
    }

    private function formatResponse(string $productsTemplate, string $filterHintsTemplate): array
    {
        return [
            'products' => $productsTemplate,
            'filterHints' => $filterHintsTemplate,
        ];
    }
}
