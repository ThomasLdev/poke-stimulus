<?php

namespace App\Twig;

use App\Enum\ProductAttribute\Name;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ProductAttributeNameExtension extends AbstractExtension
{
    private const array FLAVOR_ATTRIBUTES = [Name::FLAVOR->value, Name::FILLING->value, Name::FROSTING->value];

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_attribute_value_translation', [$this, 'getAttributeValueTranslation']),
        ];
    }

    public function getAttributeValueTranslation(string $name, string $value): string
    {
        if (in_array($name, self::FLAVOR_ATTRIBUTES, true)) {
            return 'product.attribute.flavor.options.' . $value . '.label';
        }

        return 'product.attribute.' . $name . '.options.' . $this->handleBooleanValue($value) . '.label';
    }

    private function handleBooleanValue(string $value): string
    {
        if ($value === '' || $value === '1') {
            return $value === '1' ? 'yes' : 'no';
        }

        return $value;
    }
}
