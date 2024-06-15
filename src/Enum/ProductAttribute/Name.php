<?php

namespace App\Enum\ProductAttribute;

enum Name: string
{
    case FLAVOR = 'flavor';
    case FROSTING = 'frosting';
    case FILLING = 'filling';
    case HAS_SPRINKLES = 'has_sprinkles';
    CASE IS_VEGAN = 'is_vegan';
    case DIFFICULTY = 'difficulty';
}
