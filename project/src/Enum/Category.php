<?php
namespace App\Enum;

enum Category: string
{
    case Jeux = 'Games';
    case Accessoires = 'Accessories';
    case Consoles = 'Consoles';
}