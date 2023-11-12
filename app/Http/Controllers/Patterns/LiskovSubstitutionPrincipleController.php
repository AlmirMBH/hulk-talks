<?php

namespace App\Http\Controllers\Patterns;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LiskovSubstitutionPrincipleController extends Controller
{
    //
}

// Liskov Substitution Principle: Objects of a superclass should be replaceable with objects of a subclass

// Shape interface representing a basic shape
interface Shape
{
    public function area(): float;
}

// Rectangle class implementing the Shape interface
class Rectangle implements Shape
{
    public function __construct(private float $width, private float $height)
    {
    }

    public function area(): float
    {
        return $this->width * $this->height;
    }
}

// Square class implementing the Shape interface
class Square implements Shape
{
    public function __construct(private float $side)
    {
    }

    public function area(): float
    {
        return pow($this->side, 2);
    }
}

// Usage
function calculateArea(Shape $shape)
{
    return $shape->area();
}

$rectangle = new Rectangle(5.0, 10.0);
$square = new Square(7.0);

echo 'Rectangle Area: ' . calculateArea($rectangle);
echo 'Square Area: ' . calculateArea($square);
