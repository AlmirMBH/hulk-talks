<?php

namespace App\Http\Controllers\Patterns;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OpenClosedPrincipleController extends Controller
{
    //
}

// Open/Closed Principle: Open for extension, closed for modification

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

// Circle class implementing the Shape interface
class Circle implements Shape
{
    public function __construct(private float $radius)
    {
    }

    public function area(): float
    {
        return pi() * pow($this->radius, 2);
    }
}

// Usage
$rectangle = new Rectangle(5.0, 10.0);
$circle = new Circle(7.0);

echo 'Rectangle Area: ' . $rectangle->area() . PHP_EOL;
echo 'Circle Area: ' . $circle->area() . PHP_EOL;
