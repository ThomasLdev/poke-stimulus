<?php

namespace App\Enum\ProductAttribute;

enum Difficulty: string
{
    case EASY = 'easy';
    case MEDIUM = 'medium';
    case HARD = 'hard';
    case EXPERT = 'expert';
}
